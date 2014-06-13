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

/*
 * 
 * 
 * 
 */


namespace ServerLoccioni
{
    class Program
    {
        static void Main(string[] args)
        {
            IPAddress my_ip; //IP address of the local server
            my_ip = IPAddress.Parse("192.168.33.112");
            Socket ServerSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
            MySqlConnection MySQL_Connection = new MySqlConnection();

            try
            {

                IPEndPoint ep = new IPEndPoint(my_ip, 10111);
                Console.WriteLine("EP registrato");
                ServerSocket.Bind(ep);
                ServerSocket.Listen(500); //Coda massima delle connessioni che può tenere in lista
                
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

                              
                                string server = "localhost";
                                string database = "testloccioni";
                                string uid = "root";
                                string password = "";
                                string connectionString;
                                connectionString = "SERVER=" + server + ";" + "DATABASE=" + database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";
                                try
                                {
                                    Console.WriteLine("Connessione al database...\n" + connectionString);
                                    MySQL_Connection = new MySqlConnection(connectionString);
                                    MySQL_Connection.Open();
                                    Console.WriteLine("Database connesso");
                                    string query = "SELECT IdPlant FROM uservase WHERE IdVase = " + ID.ToString();

                                    Console.WriteLine("Esecuzioni query:\n***" + query + "***");

                                    MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
                                    MySqlDataReader MySQL_DR = cmd.ExecuteReader();
                                    int PlantID = 0;
                                    while (MySQL_DR.Read())
                                    {
                                        PlantID = Convert.ToInt32(MySQL_DR["IdPlant"]);
                                        Console.WriteLine("ID della pianta " + PlantID.ToString());
                                    }

                                    MySQL_DR.Close();

                                    query = "SELECT HumMaxAir, HumMinAir, HumMaxLand, HumMinLand, Light, TempMax, TempMin FROM infoplants WHERE IdPlants = " + PlantID.ToString();

                                    Console.WriteLine("Esecuzioni query:\n***" + query + "***");

                                    cmd.CommandText = query;

                                    MySQL_DR = cmd.ExecuteReader();

                                    byte[] OutBuffer = new byte[9];

                                    OutBuffer[0] = (byte)9;
                                    OutBuffer[1] = (byte)1;

                                    while (MySQL_DR.Read())
                                    {
                                        OutBuffer[2] = (byte)Convert.ToInt32(MySQL_DR["HumMaxAir"]);
                                        Console.WriteLine("HumMaxAir: " + MySQL_DR["HumMaxAir"]);

                                        OutBuffer[6] = (byte)Convert.ToInt32(MySQL_DR["HumMinAir"]);
                                        Console.WriteLine("HumMinAir: " + MySQL_DR["HumMinAir"]);

                                        OutBuffer[4] = (byte)Convert.ToInt32(MySQL_DR["HumMaxLand"]);
                                        Console.WriteLine("HumMaxLand: " + MySQL_DR["HumMaxLand"]);

                                        OutBuffer[8] = (byte)Convert.ToInt32(MySQL_DR["HumMinLand"]);
                                        Console.WriteLine("HumMinLand: " + MySQL_DR["HumMinLand"]);

                                        OutBuffer[5] = (byte)Convert.ToInt32(MySQL_DR["Light"]);
                                        Console.WriteLine("Light: " + MySQL_DR["Light"]);

                                        OutBuffer[3] = (byte)Convert.ToInt32(MySQL_DR["TempMax"]);
                                        Console.WriteLine("TempMax: " + MySQL_DR["TempMax"]);

                                        OutBuffer[7] = (byte)Convert.ToInt32(MySQL_DR["TempMin"]);
                                        Console.WriteLine("TempMin: " + MySQL_DR["TempMin"]);
                                    }

                                    for (int i = 0; i < OutBuffer.Length; i++)
                                    {
                                        Console.WriteLine((int)OutBuffer[i]);
                                    }

                                    //Thread.Sleep(1000);

                                    WorkSocket.Send(OutBuffer);

                                    byte[] pp = new byte[20];
                                    WorkSocket.Receive(pp);
                                    for (int i = 0; i < pp.Length; i++)
                                    {
                                        Console.WriteLine(pp[i]);
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
                                break;
                            }
                    }
                }
            }

            catch (Exception e)
            {
                Console.WriteLine("Errore nel server: " + e.ToString());
            }
            Console.ReadKey();
        }
    }
}
