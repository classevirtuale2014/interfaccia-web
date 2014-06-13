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

namespace ServerLoccioni
{
    class Program
    {
        static void Main(string[] args)
        {
            IPAddress my_ip; //IP address of the local server
            my_ip = IPAddress.Parse("192.168.33.112");
            Socket ServerSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);

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
                                Console.WriteLine("Controllo della pianta associata al vaso");
                                Console.WriteLine("ID del vaso: ");
                                
                                /*
                                 * Viene effettuata la registrazione all'interno del DB
                                 * Se al vaso non corrisponde nessuna pianta ci sarà una risposta negativa
                                 */

                              /*  int ID = (int)msg[2];
                                string server = "localhost";
                                string database = "loccioniserver";
                                string uid = "root";
                                string password = "";
                                string connectionString;
                                connectionString = "SERVER=" + server + ";" + "DATABASE=" + database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";
                                MySQL_Connection = new MySqlConnection(connectionString);

                                MySQL_Connection.Open();

                                DataSet ds = new DataSet();

                                MySqlCommand cmd = MySQL_Connection.CreateCommand();

                                cmd.CommandText = "SELECT IdVase FROM UserVase WHERE IdPlant=" + ID;

                                MySqlDataAdapter MySQL_DAd = new MySqlDataAdapter(cmd);

                                MySQL_DAd.Fill(ds);

                                */



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
        }
    }
}
