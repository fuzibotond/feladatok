using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;
using MySql.Data.Common;
using MySql.Data.MySqlClient.Authentication;


namespace ConsoleApp1
{
    class Program
    {

        public static async void ParseDataFile(string dataFile)
        {

            var user_id_list = new List<int>();
            Random a = new Random();
            List<int> rndList = new List<int>();
            int MyNumber = 0;
            for (int i = 1; i < 50; i++)
            {
                MyNumber = a.Next(0, 100);
                if (!rndList.Contains(MyNumber))
                {
                    rndList.Add(MyNumber);
                   
                }
                    

            }

            var lines = File.ReadAllLines(dataFile);
            
            
            Dictionary<int, string> listKEY = new Dictionary<int, string>();
            Dictionary<int, string > listVAL = new Dictionary<int, string>();
            for (var i = 1; i < lines.Length; i++)
            {
                
                var values = lines[i].Split('|');
                int key = Convert.ToInt32(values[0]);
                listKEY[key] = values[1];
                

                i++;
                
            }
            

            foreach( var elem in rndList)
            {
                int value;
                if (listKEY.ContainsKey(elem)&& int.TryParse(listKEY[elem], out value)  && Convert.ToInt32( listKEY[elem])>=0)
                {
                    user_id_list.Add(Convert.ToInt32(listKEY[elem]));
                    //Console.WriteLine(listKEY[elem]);
                     
                }


            }


            MySqlConnection connection;
            string server;
            string database;
            string uid;
            string password;
            server = "localhost";
            database = "cs_beugro";
            uid = "root";
            password = "";
            string connectionString;
            connectionString = "SERVER=" + server + ";" + "DATABASE=" +
            database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";

            connection = new MySqlConnection(connectionString);
           
            connection.Open();
            foreach(var elem in user_id_list)
            {
                Console.WriteLine(elem);
            }
          
            MySqlCommand command = new MySqlCommand("SELECT user.id, user.name, car.brand, car.model FROM user join user_car on user.id=user_car.user join car on car.id=user_car.car", connection);
            using (MySqlDataReader reader = command.ExecuteReader())
            {
                string folder = @"C:";
                // Filename  
                string fileName = "result.txt";
                // Fullpath. You can direct hardcode it if you like.  
                string fullPath = folder + fileName;

                string to_write = "";
                string docPath = Environment.GetFolderPath(Environment.SpecialFolder.MyDocuments);
                using (StreamWriter outputFile = new StreamWriter(Path.Combine(docPath, "WriteLines.txt")))
                {



                    while (reader.Read())
                    {

                        if (user_id_list.Contains(Convert.ToInt32(reader["id"])))
                        {
                            Console.WriteLine(Convert.ToInt32(reader["id"]) + " " + reader["name"] + " " + reader["brand"] + " " + reader["model"]);
                            string temp1 = reader["name"] + " " + reader["brand"] + " " + reader["model"] + "\n";
                            to_write += temp1;

                            outputFile.WriteLine(temp1);


                        }



                    }
                    string[] helper = new string[] { to_write };
                    File.WriteAllLines(fullPath, helper);      //bin\Debug\result.txt 
                }

              
                

            }

            
        }
        static void Main(string[] args)
        {
            string path = @"TextFile1.txt";
            ParseDataFile(path);
        }
    }
}
