using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net.Sockets;
using System.Net;
using System.IO;
using MySql.Data;
using MySql.Web;
using MySql.Data.MySqlClient;
using System.Data;
using System.Threading;

namespace ServerLoccioni
{
    class Program
    {
        private static bool Connect(out Socket ServerSocket, out MySqlConnection MySQL_Connection)
        {
            IPAddress my_ip; //IP address of the local server
            my_ip = IPAddress.Parse("192.168.33.106");
            
            ServerSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
            
            string server = "localhost";
            string database = "loccioniserver";
            string uid = "root";
            string password = "";
            string connectionString;
            
            connectionString = "SERVER=" + server + ";" + "DATABASE=" + database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";
            
            Console.WriteLine("Connessione al database...\n" + connectionString);

            MySQL_Connection = new MySqlConnection(connectionString);

            try
            {
                MySQL_Connection.Open();
                Console.WriteLine("Database connesso");
            }
            catch (Exception e)
            {
                Console.WriteLine("Impossibile connettersi al DB " + e.ToString());
                return false;
            }

            try
            {
                IPEndPoint ep = new IPEndPoint(my_ip, 10111);
                Console.WriteLine("End Point registrato");
                ServerSocket.Bind(ep);
                ServerSocket.Listen(500); //Coda massima delle connessioni che può tenere in lista
            }
            catch (Exception e)
            {
                Console.WriteLine("Errore nel server: " + e.ToString());
            }

            return true;
        }

        static void Main(string[] args)
        {
            MySqlConnection MySQL_Connection;
            Socket ServerSocket;

            if(!Connect(out ServerSocket, out MySQL_Connection))
            {
                Console.WriteLine("Impossiible connettersi alle risorse");
                return;
            }

            try
            {
                while (true)
                {
                    Console.WriteLine("Server in ascolto nel socket " + ServerSocket.LocalEndPoint.ToString());
                    Socket WorkSocket = ServerSocket.Accept();
                    Console.WriteLine("Server in funzione nel socket " + WorkSocket.LocalEndPoint.ToString() + " " + WorkSocket.RemoteEndPoint.ToString());

                    byte[] InBuffer = new byte[1024];
                    WorkSocket.Receive(InBuffer);
                    byte[] msg = new byte[InBuffer[0]];

                    for (int i = 0; i < msg.Length; i++)
                    {
                        msg[i] = InBuffer[i];
                    }

                    Console.WriteLine("Messaggio arrivato: ");

                    for (int i = 0; i < msg[0]; i++)
                    {
                        Console.WriteLine(msg[i]);
                    }

                    Console.WriteLine("");

                    switch (msg[1])
                    {
                        case 0:
                        {
                            int ID = (int)msg[2];
                            Console.WriteLine("Controllo della pianta associata al vaso");
                            Console.WriteLine("ID del vaso: " + ID);

                                    /*
                                     * Viene effettuata la registrazione all'interno del DB
                                     * Se al vaso non corrisponde nessuna pianta ci sarà una risposta negativa
                                     */

                                    try
                                    {
                                        bool Continue = true;

                                        string query = "SELECT TypeId FROM pianta WHERE VaseId = " + ID.ToString();

                                        Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

                                        MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
                                        MySqlDataReader MySQL_DR = cmd.ExecuteReader();
                                        int PlantID = 0;
                                        while (MySQL_DR.Read())
                                        {
                                            try
                                            {
                                                PlantID = Convert.ToInt32(MySQL_DR["TypeId"]);
                                                Console.WriteLine("ID della pianta " + PlantID.ToString());
                                            }
                                            catch (Exception e)
                                            {
                                                Continue = false;
                                                Console.WriteLine("No match found");
                                            }
                                        }
                                        if (Continue)
                                        {

                                            query = "SELECT HumMaxAir, HumMinAir, HumMaxLand, HumMinLand, Light, TempMax, TempMin FROM infoplants WHERE IdPlants = " + PlantID.ToString();

                                            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

                                            cmd.CommandText = query;

                                            MySQL_DR.Close();

                                            MySQL_DR = cmd.ExecuteReader();

                                            byte[] OutBuffer = new byte[9];
                                            OutBuffer[0] = (byte)9;
                                            OutBuffer[1] = (byte)1;

                                            while (MySQL_DR.Read())
                                            {
                                                OutBuffer[2] = (byte)Convert.ToInt32(MySQL_DR["HumMinAir"]);
                                                Console.WriteLine("HumMinAir: " + MySQL_DR["HumMinAir"].ToString());

                                                OutBuffer[6] = (byte)Convert.ToInt32(MySQL_DR["HumMaxAir"]);
                                                Console.WriteLine("HumMaxAir: " + MySQL_DR["HumMaxAir"].ToString());

                                                OutBuffer[4] = (byte)Convert.ToInt32(MySQL_DR["HumMinLand"]);
                                                Console.WriteLine("HumMinLand: " + MySQL_DR["HumMinLand"].ToString());

                                                OutBuffer[8] = (byte)Convert.ToInt32(MySQL_DR["HumMaxLand"]);
                                                Console.WriteLine("HumMaxLand: " + MySQL_DR["HumMaxLand"].ToString());

                                                OutBuffer[5] = (byte)Convert.ToInt32(MySQL_DR["Light"]);
                                                Console.WriteLine("Light: " + MySQL_DR["Light"].ToString());

                                                OutBuffer[3] = (byte)Convert.ToInt32(MySQL_DR["TempMin"]);
                                                Console.WriteLine("TempMin: " + MySQL_DR["TempMin"].ToString());

                                                OutBuffer[7] = (byte)Convert.ToInt32(MySQL_DR["TempMax"]);
                                                Console.WriteLine("TempMax: " + MySQL_DR["TempMax"].ToString());

                                            }

                                            MySQL_DR.Close();

                                         /*   for (int i = 0; i < OutBuffer.Length; i++)
                                            {
                                                Console.WriteLine(OutBuffer[i]);
                                            }*/

                                            WorkSocket.Send(OutBuffer);
                                        }
                                        else
                                        {
                                            byte[] OutBuffer = new byte[2];
                                            OutBuffer[0] = (byte)0;
                                            OutBuffer[1] = (byte)2;
                                            WorkSocket.Send(OutBuffer);
                                        }

                                    }
                                    catch (Exception e)
                                    {
                                        Console.WriteLine("Errore nella connessione al DB: " + e.ToString());

                                        byte[] OutBuffer = new byte[2];
                                        OutBuffer[0] = (byte)OutBuffer.Length;
                                        OutBuffer[1] = (byte)0;

                                        WorkSocket.Send(OutBuffer);

                                        MySQL_Connection.Close();
                                    }
                                    break;
                                }
                            case 1:
                                {
                                    //aggiornamento
                                    Console.WriteLine("Aggiornamento");

                                    int ID = (int)msg[2];

                                    Console.WriteLine("Aggiornamento storico del vaso: " + ID.ToString());

                                    string query = "SELECT TypeId FROM pianta WHERE VaseId = " + ID.ToString();

                                    try
                                    {
                                        MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);

                                        Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

                                        MySqlDataReader MySQL_DR = cmd.ExecuteReader();

                                        bool Continue = true;

                                        int PlantID = 0;
                                        while (MySQL_DR.Read())
                                        {
                                            try
                                            {
                                                PlantID = Convert.ToInt32(MySQL_DR["TypeId"]);
                                                Console.WriteLine("ID della pianta " + PlantID.ToString());
                                            }
                                            catch (Exception e)
                                            {
                                                Continue = false;
                                                Console.WriteLine("No match found\n" + e.ToString());
                                            }
                                        }

                                        MySQL_DR.Close();

                                        if (Continue)
                                        {
                                            try
                                            {
                                                query = "INSERT INTO storico (ID, IdPlant, HumAir, HumLand, Temp, Light, WaterLevel, Battery, UpdateTime) VALUES (NULL, '" + PlantID.ToString() + "', '" + msg[3].ToString() + "', '" + msg[4].ToString() + "', '" + msg[5].ToString() + "', '" + msg[6].ToString() + "', '" + msg[7].ToString() + "', '" + msg[8].ToString() + "', now())";
                                                cmd = new MySqlCommand(query, MySQL_Connection);
                                                Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");
                                                cmd.ExecuteNonQuery();
                                            }
                                            catch(Exception e)
                                            {
                                                Console.WriteLine(e.ToString());
                                            }
                                        }
                                        else
                                        {
                                          /*  byte[] OutBuffer = new byte[2];
                                            OutBuffer[0] = (byte)0;
                                            OutBuffer[1] = (byte)2;
                                            WorkSocket.Send(OutBuffer);*/
                                        }
                                    }

                                    catch (Exception e)
                                    {
                                        Console.WriteLine("Errore nella connessione al DB: " + e.ToString());

                                        byte[] OutBuffer = new byte[2];
                                        OutBuffer[0] = (byte)OutBuffer.Length;
                                        OutBuffer[1] = (byte)0;

                                        WorkSocket.Send(OutBuffer);

                                        MySQL_Connection.Close();
                                    }

                                    break;
                                }
                            case 2:
                                {
                                    //emergenza
                                    break;
                                }
                        }
                }
            }//asdaaaf
            catch (Exception e)
            {
                Console.WriteLine("Errore nel server: " + e.ToString());
            }
            Console.ReadKey();
        }
    }
}
