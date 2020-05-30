<?php 
	const SERVER = "localhost";
	const DB     = "bd_sis-biblio-mvc";
	const USER   = "root";
	const PASS   = "";

	const SGBD   = "mysql:host=".SERVER.";dbname=".DB; 

//SE COLOCAN LAS LLAVES QUE SE VAN A MOSTAR EN LA URL
// METODO DE ENCRIPTACION Y DESENCRIPTACION
	const METHOD = "AES-256-CBC";
	const SECRET_KEY = "BP2019";
	const SECRET_IV = "231112";