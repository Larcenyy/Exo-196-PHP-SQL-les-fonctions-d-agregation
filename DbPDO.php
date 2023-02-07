<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'test';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $request = self::$db->prepare("SELECT MIN(age) as minimum FROM user");
                $request2 = self::$db->prepare("SELECT MAX(age) as max FROM user");
                $request3 = self::$db->prepare("SELECT count(*) as number FROM user WHERE id");
                $request4 = self::$db->prepare("SELECT count(*) as number FROM user WHERE numero >= 5");
                $request5 = self::$db->prepare("SELECT AVG(age) as moyenne_age FROM user");

                $state = $request->execute();
                $state = $request2->execute();
                $state = $request3->execute();
                $state = $request4->execute();
                $state = $request5->execute();

                if ($state){
                    $min = $request->fetch();
                    $max = $request2->fetch();
                    $counter1 = $request3->fetch();
                    $counter2 = $request4->fetch();
                    $counter3 = $request5->fetch();
                    echo "Age minimum est : " . $min["minimum"] . 'ans' . "<br>";
                    echo "Age maximum est : " . $max["max"] . 'ans' . "<br>";
                    echo "Nombre total d'utilisateur : " . $counter1["number"] . "<br>";
                    echo "Nombre utilisateur ayant numéro de rue plus grand ou égale à 5  : " . $counter2["number"] . "<br>";
                    echo "Moyenne d'âge d'utilisateur : " . $counter3["moyenne_age"] . "<br>";
                }
                else{
                    echo "Problème";
                }
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;

    }
}