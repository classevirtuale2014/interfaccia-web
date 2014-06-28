using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net;
using System.Net.Sockets;
using System.Threading;
/****************/
using MySql.Data;
using MySql.Data.MySqlClient;
/***These libraries aren't available by default, you can download them here: http://dev.mysql.com/downloads/connector/net/6.1.html ***/
using Tweetinvi;
using System.Net.Mail;

/*** BECAUSE OF SOME ISSUES WITH THE NETWORK WE COULDN'T IMPLEMENT THE TWITTER INTERFACE BUT WE LEFT THE CODE ANYWAY. WE AREN'T SURE IF IT COULD WORK ***/

namespace ServerLoccioniAsyn
{
    class Program
    {
        //The ManualResetEvent object check if the asynchronous operation of listening for a new connection could be performed
        private static ManualResetEvent allDone = new ManualResetEvent(false);
        //MySqlConnection object connect the C# server application to the database
        private static MySqlConnection MySQL_Connection;

        private static void StartServer()
        {
            /*** Initializing the Socket ***/
            //IPAddress object which represents the ip address of the local host
            IPAddress MyIP = IPAddress.Parse("172.17.11.87");
            //TCP port where the socket will be binded for listening to incoming connection
            int Port = 10111;
            
            Socket ServerSocket;

            /*
             * Initializing the Socket which have to check for connection request
             * AddressFamily.InterNetwork = IPv4 address
             * SocketType.Stream = the socket communicates with a single peer and requests a connection before starting the communication (TCP)
             * ProtocolType.Tcp = the type of protocol used   
             */
            ServerSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);

            //Parameters needed for the connection to the server with the local MySQL database
            string server = "localhost"; //Name of the host where the dabatabase is stored (localhost is the default name for a local DB)
            string database = "loccioniserver"; //Name of the database
            string uid = "root"; //Name of the user (root is the default username)
            string password = ""; //There is no password
            string connectionString;

            //When initializing the MySQL object you have to pass a string in the constrictor method with this syntax
            connectionString = "SERVER=" + server + ";" + "DATABASE=" + database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";

            Console.WriteLine("Database:\n" + connectionString + "\n");

            //Connect the MySqlConnection object with the DataBase
            MySQL_Connection = new MySqlConnection(connectionString);

            Console.WriteLine("***Database connected\n" + connectionString);

            try
            {
                //Open the connection to the database
                MySQL_Connection.Open();

                //Set twitter credentials
                Tweetinvi.TwitterCredentials.SetCredentials("2583664454-Rw4q57IgqbRWV10E2RpgbNJ0aMsj4D38T5Z2Dr5", "c38ojoVCVZLqKVum0mzFKFFhTQnYp864JGZxKA0qKVCQl", "4KAhEFssStG5sVJP22v78QwjE", "07GfEDMNOof23Qa3KBz05ittYu9FfC3Lumju79eRgUc58hmQms");
                
                //IPEndPoint object which represent the local host (in this case is the server). The EndPoint is characterized by the local ip address and the TCP port
                IPEndPoint ep = new IPEndPoint(MyIP, Port);
                //Binding the listening socket with the IPEndPoint which represent the host
                ServerSocket.Bind(ep);
                Console.WriteLine("***End point connected");
                //Set the number of connection wich could be put in a queue (you can set any number but it will be limitated by the OS)
                ServerSocket.Listen(1024);
                //Loop which will put the ServerSocket into a listening state
                while (true)
                {
                    /*
                     * Using an asynchronous method the program works with two separate threads. 
                     * This means that everytime that the socket will be set into a listening state (calling the BeginAccept methos, which represent an asynchronous operation)
                     * a new thread starts. This causes an overload of useless thread becase the while loop calls the BeginAccept method everytime it iterates.
                     * 
                     * For avoiding this problem the Reset method (from ManualResetEvent class) is used. This method set the current thread usigned and it stops when
                     * the WaitOne method is called. The thread restarts after that the state of the thread is setted as signed.
                     */
                    allDone.Reset();
                    Console.WriteLine("Server listening on " + ServerSocket.LocalEndPoint.ToString());

                    //The socket calls the AcceptCallback method to manage the incoming connection
                    ServerSocket.BeginAccept(new AsyncCallback(AcceptCallback), ServerSocket);
                    allDone.WaitOne();
                }
            }
            catch (Exception e)
            {
              Console.WriteLine("\n\nError: \n" + e.ToString()+"\n\n");
            }
        }

        private static void AcceptCallback(IAsyncResult ar)
        {
            //Set the state of the thread as signed
            allDone.Set();

            //StateObject object contain a Socket and a byte array for storing the incoming data. It is used as a referance for two different object which need to be used as a single parameter 
            StateObject state = new StateObject();

            //Convert the second parameter of the BeginAccept method (stored in the object "ar") into a socket which is the socket used for accepting the connection
            Socket ServerSocket = (Socket)ar.AsyncState;

            //Set the socket of the object state as a new socket characterized by IP address and TCP port of the server and IP address and TCP port of the client. This represent a single connection between two hosts
            state.WorkSocket = ServerSocket.EndAccept(ar);
            Console.WriteLine("Remote host connected on socket: " + state.WorkSocket.RemoteEndPoint.ToString() + "\n");
            //Set the Timeout receving time, if there is any error during the Receive method in the connection, the server stops and the method generates an exeption.
            state.WorkSocket.ReceiveTimeout = 5000;
            try
            {
                //The server waits for incoming data which will be memorized in InBuffer byte array.
                state.WorkSocket.Receive(state.InBuffer);
            }
            catch (Exception e)
            {
                Console.WriteLine("Timeout error");
                state.WorkSocket.Close();
                return;
            }

            //This method handles the received data. 
            ReadRequest(state);
        }

        private static void ReadRequest(StateObject state)
        {
            /*
             * How messages are structured:
             * First byte: lenght;
             * Second byte: kind of request. This value is unique, it is stored in the code of each vase.
             * Third byte: serial number of the vase
             */

            Console.WriteLine("Lettura del messaggio: \n");
            
            //Prints each byte of the data.
            for (int i = 0; i < state.InBuffer[0]; i++)
            {
                Console.Write(state.InBuffer[i] + " ");
            }

            Console.Write('\n');

            // This variable indicates the kind of request which will be intefied in the switch-case statment. 
            byte KindOfRequest = state.InBuffer[1];

            //Memorize the received serial ID of the vase.
            int SerialID = state.InBuffer[2];
            Console.WriteLine("Serial vase number: " + SerialID + "\n");

            //This byte array is used for outgoing messages. The object must be initialized first.
            byte[] OutBuffer = new byte[1];

            /*
             * In this part, the program searches in the database the main information of the vase. 
             * The fields are:
             * VaseID = ID of the vase associated with the serial number;
             * PlantID = ID of the plant which is identified by the VaseID, kind of plant and UserID
             * UserID = ID of the user that registrered the vase
             * 
             * (check the E/R model of the dabatabase for more information) 
             * 
             * If the GetVaseID, GetPlantID and GetUserID methods return -1, an error occurred while searching of the information.
             * The server sends an error message (the "KindOfRequest" byte setted to 0).
             */

            /******_MAIN_INFORMATION_******/
            int VaseID = GetVaseID(SerialID);
            if (VaseID == -1)
            {
                Console.WriteLine("Errore nella ricerca dell'ID del vaso\n");
                OutBuffer = new byte[2];
                OutBuffer[0] = (byte)2; 
                OutBuffer[1] = (byte)0; 
                Send(state.WorkSocket, OutBuffer);
                state.WorkSocket.Close();
                return;
            }

            int PlantID = GetPlantID(VaseID);
            if (PlantID == -1)
            {
                Console.WriteLine("Errore nella ricerca dell'ID della pianta");
                OutBuffer = new byte[2];
                OutBuffer[0] = (byte)2;
                OutBuffer[1] = (byte)0;
                Send(state.WorkSocket, OutBuffer);
                state.WorkSocket.Close();
                return;
            }

            int UserID = GetUserID(PlantID);
            if (PlantID == -1)
            {
                Console.WriteLine("Errore nella ricerca dell'ID dell'utente");
                OutBuffer = new byte[2];
                OutBuffer[0] = (byte)2;
                OutBuffer[1] = (byte)0;
                Send(state.WorkSocket, OutBuffer);
                state.WorkSocket.Close();
                return;
            }

            string PlantName = GetPlantName(PlantID);
            //if()
            /****************************************/

            switch (KindOfRequest)
            {
               //The client requests the max and min parameters information
                case 0:
                    {
                        Console.WriteLine("Research max and min");

                         //Search the type of plant associated at the PlantID (returns -1 in case of errors)
                        int KindOfPlant = GetKindOfPlant(PlantID);
                        if (KindOfPlant == -1)
                        {
                            Console.WriteLine("Errore nella ricerca della pianta");
                            OutBuffer = new byte[2];
                            OutBuffer[0] = (byte)2;
                            OutBuffer[1] = (byte)0;
                        }
                        else
                        {
                            //After the plant type has been identified, the program searches the Max and Min parameters and fills the OutBuffer array.
                            byte[] msg = GetMaxMin(KindOfPlant);
                            OutBuffer = new byte[msg.Length + 2];
                            OutBuffer[0] = (byte)OutBuffer.Length;
                            OutBuffer[1] = (byte)1;

                            for (int i = 0; i < msg.Length; i++)
                            {
                                OutBuffer[i + 2] = msg[i];
                            }
                        }
                        break;
                    }
                //The client sends the update which will be stored in the "storico" table in the database
                case 1:
                    {
                        Console.WriteLine("Update database");

                        int NumberOfLectures = (int)((state.InBuffer[0] - 4) / 5);
                        Console.WriteLine("Number of lectures from last update: " + NumberOfLectures.ToString());

                        for (int i = 0; i < NumberOfLectures; i++)
                        {
                            UpdateDatabase(PlantID, state.InBuffer[3 * (i + 1)], state.InBuffer[4 * (i + 1)], state.InBuffer[5 * (i + 1)], state.InBuffer[6 * (i + 1)], state.InBuffer[7 * (i + 1)], state.InBuffer[8 * (i + 1)]);
                        }
                        
                        OutBuffer = new byte[3];
                        OutBuffer[0] = (byte)OutBuffer.Length;
                        OutBuffer[1] = (byte)0;

                        //This query selects the update time which will be sent to the client and refers to the time (in minutes) that the client must wait before sending the update.
                        string query = "SELECT update_freq FROM settings WHERE UserID = " + UserID.ToString();
                        Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");
                        
                        //MySqlCommand object refers to the query that are executed in the database connected in the MySQL_Connection object.
                        MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
                        //MySqlDataReader is used to read the result of the query.
                        MySqlDataReader MySQL_DR = cmd.ExecuteReader();
                        
                        //The variable where the update time is memorized
                        int frequency = 0;

                        //The loop check each row that matches with the query
                        while (MySQL_DR.Read())
                        {
                            try
                            {
                                //For the row selected get the data in the update_t column.
                                frequency = Convert.ToInt32(MySQL_DR["update_freq"]);
                                Console.WriteLine("Frequency " + UserID.ToString());
                            }
                            catch (Exception e)
                            {
                                Console.WriteLine("No match found");
                            }
                        }

                        //Then fill the OutBuffer[3] array's cell with the  value read in the database.
                           // OutBuffer[2] = (byte)frequency;
                        OutBuffer[2] = (byte)1;
                        //TODO: Uncomment OutBuffer[3] = (byte)frequency;
                        MySQL_DR.Close();
                        break;
                    }
                //If any value read by the client's sensors and sent to the server is lower or higher than the max and min already sent, the client sends a message with KindOfMessage byte with value 2.
                case 2:
                    {
                        //This message is characterized by series of 1 and 0 (for each byte) which determine which parameters aren't normal.
                        Console.WriteLine("Error message");
                        byte[] Error = new byte[state.InBuffer[0] - 3];
                        for(int i = 3; i < state.InBuffer[0]; i++)
                        {
                            Error[i - 3] = state.InBuffer[i];
                        }
                        Warning(PlantID, Error);
                        if (TwitterEnabled(UserID))
                        {
                            string TwitterUserName = GetTwitterUserName(UserID);
                            SendTweet(Error, PlantID, TwitterUserName, PlantName);
                            //SendTweet(Error, PlantID, "username");
                        }
                        break;
                    }
                //If no KindOfRequest byte mathes with the switch-case statement, the default case set the message as an error (second byte equals to 1)
                default:
                    {
                        Console.WriteLine("Request error");
                        OutBuffer = new byte[2];
                        OutBuffer[0] = (byte)OutBuffer.Length;
                        OutBuffer[1] = (byte)1;
                        break;
                    }
            }
            //The Send method sends the OutBuffer array to the client connected in the worksocket connection.
            Send(state.WorkSocket, OutBuffer);
            state.WorkSocket.Close();
        }

        private static bool TwitterEnabled(int UserID)
        {
            bool isEnabled = false;

            Console.WriteLine("Check for twitter");
            string query = "SELECT twitter FROM settings WHERE UserID = " + UserID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    UserID = Convert.ToInt32(MySQL_DR["twitter"]);
                    Console.WriteLine("Twitter: " + UserID.ToString());
                    isEnabled = true;
                }
                catch (Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return isEnabled;
                }
            }

            MySQL_DR.Close();

            return isEnabled;
        }

        private static int GetUserID(int PlantID)
        {
            int UserID = -1;
            Console.WriteLine("Search user ID");

            string query = "SELECT UserID FROM pianta WHERE ID = " + PlantID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    UserID = Convert.ToInt32(MySQL_DR["UserID"]);
                    Console.WriteLine("ID dell'utente " + UserID.ToString());
                }
                catch (Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return UserID;
                }
            }

            MySQL_DR.Close();

            return UserID;
        }
        
        private static string GetTwitterUserName(int UserID)
        {
            string TwitterUserName = "";

            string query = "SELECT twitter_username FROM user WHERE IdUser = '" + UserID.ToString() + "'";

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    TwitterUserName = MySQL_DR["twitter_username"].ToString();
                    Console.WriteLine("ID del tipo di pianta " + TwitterUserName);
                }
                catch (Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return TwitterUserName;
                }
            }

            MySQL_DR.Close();

            return TwitterUserName;
        }

        private static int GetKindOfPlant(int PlantID)
        {
            int KindOfPlant = -1;

            Console.WriteLine("Controllo del tipo di pianta associata al vaso");
            string query = "SELECT TypeId FROM pianta WHERE ID = " + PlantID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    KindOfPlant = Convert.ToInt32(MySQL_DR["TypeId"]);
                    Console.WriteLine("ID del tipo di pianta " + KindOfPlant.ToString());
                }
                catch(Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return KindOfPlant;
                }
            }

            MySQL_DR.Close();

            return KindOfPlant;
        }

        private static int GetVaseID(int SerialID)
        {
            int VaseID = -1;

            Console.WriteLine("Controllo dell'ID associato al vaso");

            string query = "SELECT ID FROM vase WHERE Code = " + SerialID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();


            while (MySQL_DR.Read())
            {
                try
                {
                    VaseID = Convert.ToInt32(MySQL_DR["ID"]);
                    Console.WriteLine("ID del vaso " + VaseID.ToString());
                }
                catch (Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return VaseID;
                }
            }

            MySQL_DR.Close();
            return VaseID;
        }

        private static void UpdateDatabase(int PlantID, int HumAir, int HumLand, int Temp, int Light, int WaterLevel, int Battery)
        {
            string query = "INSERT INTO storico (ID, IdPlant, HumAir, HumLand, Temp, Light, WaterLevel, Battery, UpdateTime) VALUES (NULL, '"+ PlantID.ToString() + "', '" + HumAir.ToString() + "', '" + Temp.ToString() + "', '" + HumLand.ToString() + "', '" + Light.ToString() + "', '" + WaterLevel.ToString() + "', '" + Battery.ToString() + "', now())";
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");            
            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            cmd.ExecuteNonQuery();
        }

        private static void Warning(int PlantID, byte[] Error)
        {
            string query = "UPDATE alarm SET battery = '" + Error[0].ToString() + "', HumAirLow = '" + Error[1].ToString() + "', HumAirHigh = '" + Error[2].ToString() +"' , TempLow = '" + Error[3].ToString() +"', TempHigh = '" + Error[4].ToString() +"', Watering = '" + Error[5].ToString() +"', LightLow = '" + Error[6].ToString() + "' , Refil = '" + Error[7].ToString() +"' WHERE IdPlant = '" + PlantID.ToString() + "'";
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");
            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            cmd.ExecuteNonQuery();       
        }

        private static byte[] GetMaxMin(int KindOfPlant)
        {
            string query = "SELECT HumMaxAir, HumMinAir, HumMaxLand, HumMinLand, Light, TempMax, TempMin FROM infoplants WHERE IdPlants = " + KindOfPlant.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***\n");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            byte[] msg = new byte[7];

            while (MySQL_DR.Read())
            {
                msg[0] = (byte)Convert.ToInt32(MySQL_DR["HumMaxAir"]);
                Console.WriteLine("HumMaxAir: " + MySQL_DR["HumMaxAir"].ToString());

                msg[4] = (byte)Convert.ToInt32(MySQL_DR["HumMinAir"]);
                Console.WriteLine("HumMinAir: " + MySQL_DR["HumMinAir"].ToString());

                msg[2] = (byte)Convert.ToInt32(MySQL_DR["HumMaxLand"]);
                Console.WriteLine("HumMaxLand: " + MySQL_DR["HumMaxLand"].ToString());

                msg[6] = (byte)Convert.ToInt32(MySQL_DR["HumMinLand"]);
                Console.WriteLine("HumMinLand: " + MySQL_DR["HumMinLand"].ToString());

                msg[3] = (byte)Convert.ToInt32(MySQL_DR["Light"]);
                Console.WriteLine("Light: " + MySQL_DR["Light"].ToString());

                msg[1] = (byte)Convert.ToInt32(MySQL_DR["TempMax"]);
                Console.WriteLine("TempMax: " + MySQL_DR["TempMax"].ToString());

                msg[5] = (byte)Convert.ToInt32(MySQL_DR["TempMin"]);
                Console.WriteLine("TempMin: " + MySQL_DR["TempMin"].ToString());

            }

            MySQL_DR.Close();

            return msg;
        }

        private static int GetPlantID(int VaseID)
        {
            int PlantID = -1;

            Console.WriteLine("Controllo dell'ID associato al vaso");

            string query = "SELECT ID FROM pianta WHERE VaseId = " + VaseID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    PlantID = Convert.ToInt32(MySQL_DR["ID"]);
                    Console.WriteLine("ID della pianta " + PlantID.ToString());
                }
                catch (Exception e)
                {
                    Console.WriteLine("No match found");
                    MySQL_DR.Close();
                    return PlantID;
                }
            }

            MySQL_DR.Close();

            return PlantID;
        }

        private static string GetPlantName(int PlantID)
        {
            string PlantName = "Pianta";

            Console.WriteLine("Controllo del nome associato alla pianta");

            string query = "SELECT Name FROM pianta WHERE ID = " + PlantID.ToString();
            Console.WriteLine("\nEsecuzioni query:\n***" + query + "***");

            MySqlCommand cmd = new MySqlCommand(query, MySQL_Connection);
            MySqlDataReader MySQL_DR = cmd.ExecuteReader();

            while (MySQL_DR.Read())
            {
                try
                {
                    PlantID = Convert.ToInt32(MySQL_DR["Name"]);
                    Console.WriteLine("Nome della pianta " + PlantName);
                }
                catch (Exception e)
                {
                    Console.WriteLine("Errore nel trovare il nome della pianta");
                    MySQL_DR.Close();
                    return PlantName;
                }
            }

            MySQL_DR.Close();

            return PlantName;
        }

        private static void SendTweet(byte[] Error, int PlantID, string User, string PlantName)
        {
            Console.WriteLine("There is a tweet!");

            for (int i = 0; i < Error.Length; i++)
            {
                if (Error[i] != 0)
                {
                    switch (i)
                    {
                        case 0:
                            {
                                var tweet = Tweet.PublishTweet("La mia batteria è quasi scarica!\n#" + PlantName + "@" + User);
                                break;
                            }
                        case 1:
                            {
                                var tweet = Tweet.PublishTweet("L'midità del terreno è troppo bassa per i miei gusti.\n#" + PlantName + " @" + User);
                                break;
                            }
                        case 2:
                            {
                                var tweet = Tweet.PublishTweet("L'aria è troppo asciutta.\n#" + PlantName + " @" + User);
                                break;
                            }
                        case 3:
                            {
                                var tweet = Tweet.PublishTweet("Ho freddo.\n#" + PlantName + " @" + User);
                                break;
                            }
                        case 4:
                            {
                                var tweet = Tweet.PublishTweet("Ho troppo caldo.\n#" + PlantName + " @" + User);
                                break;
                            }
                        case 6:
                            {
                                var tweet = Tweet.PublishTweet("Non sto ricevendo abbastanza luce.\n#" + PlantName + " @" + User);
                                break;
                            }
                        case 7:
                            {
                                var tweet = Tweet.PublishTweet("Il mio serbatoio è vuoto.\n#" + PlantName + " @" + User);
                                break;
                            }
                    }
                }
            }
        }

        private static void Send(Socket socket, byte[] buffer)
        {
            socket.Send(buffer);
        }

        static void Main(string[] args)
        {
            Console.WriteLine("***LOCCIONI SERVER***");
            //Call the StartServer method
            StartServer();
            Console.ReadKey();
        }
    }

    class StateObject
    {
        //Socket used for the transmission.
        public Socket WorkSocket = null;
        // Receive buffer.
        public byte[] InBuffer = new byte[1024];
        //Connection with the database
        public MySqlConnection MySQL_Connection = null;

        public StateObject()
        {
            WorkSocket = null;
        }
    }
}