<?php

class JokeController 
{
    public function __construct(private DatabaseTable $jokesTable, private DatabaseTable $authorsTable) 
    {

    }

    public function list()
    {
        $result = $this->jokesTable->findAll();
    
        $jokes = [];
        foreach($result as $joke) {
            $author = $this->authorsTable->find('id', $joke['authorid'])[0];

            $jokes []= [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        }
        $title = "Lista dowcipów";
        $totalJokes = $this->jokesTable->total();

        ob_start(); //otwarcie bufora
        include __DIR__.'/../templates/jokes.html.php'; //wczytanie konstrukcji html z pliku tworzącego listę dowcipów
        $output = ob_get_clean(); //przeniesienie bufora do zmiennej i wyczyszczenie go

        return ['output'=>$output, 'title'=>$title];
    }

    public function home()
    {
        $title = 'Internetowa baza dowcipów';
        ob_start();
        include __DIR__.'/../templates/home.html.php';
        $output = ob_get_clean();

        return ['output'=>$output, 'title'=>$title];
    }

    public function delete()
    {
        $this->jokesTable->delete('id', $_POST['id']);

        header('location: index.php?action=list');
    }

    public function edit()
    {
        if (isset($_POST['joke'])) {
            $joke = $_POST['joke'];
            $joke['jokedate'] = new DateTime();
            $joke['authorId'] = 1;

            $this->jokesTable->save($joke);

            header('location: index.php=action=list');
        } else {
            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->find('id', $_GET['id'])[0] ?? null;

            } else {
                $joke = null;
            }

            $title = 'Edytuj dowcip';
            
            ob_start();
                include __DIR__.'/../templates/editjoke.html.php';
            $output = ob_get_clean();
        }

        return ['output'=>$output, 'title'=>$title];
    }
}