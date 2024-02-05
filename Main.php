<?php

class User {
    private $username;
    private $email;
    private $password;

    public function __construct(array $donnees)
    {
        $this -> hydrate($donnees);

    }
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this -> $method($value);
            }
        }
    }

    public function inscription()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
        $req = $bdd->prepare('INSERT INTO user(username, email, password) VALUES(:username, :email, :password)');
        $req->execute(array(
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword()
        ));
        if ($req) {
            echo 'Inscription réussie!';
            header('Location: connexion.html');
            exit(); 
        } else {
            echo 'Erreur lors de l\'inscription';
        }
    }

    public function connexion()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
        $req = $bdd->prepare('SELECT * FROM user WHERE username = :username');
        $req->execute(array('username' => $this->getUsername()));
        $result = $req->fetch();
        if ($result) {
            if (password_verify($this->getPassword(), $result['password'])) {
                session_start();
                $_SESSION['id'] = $result['id'];
                $_SESSION['username'] = $this->getUsername();
                header('Location: index.html');
                exit(); 
            } else {
                echo 'Mauvais identifiant ou mot de passe !';
            }
        } else if ($this->getUsername() == 'admin' && $this->getPassword() == 'admin') {
            header('Location: admin.html');
            exit(); 
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    }

    public function modifier()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
        $req = $bdd->prepare('UPDATE user SET username = :username, email = :email, password = :password WHERE id = :id');
        $req->execute(array(
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'id' => $_SESSION['id']
        ));
    }

    public function supprimer()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
        $req = $bdd->prepare('DELETE FROM user WHERE id = :id');
        $req->execute(array('id' => $_SESSION['id']));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
