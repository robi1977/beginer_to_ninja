<?php

class JokeController 
{
    public function __construct(private DatabaseTable $jokesTable, private DatabaseTable $authorsTable) 
    {

    }


}