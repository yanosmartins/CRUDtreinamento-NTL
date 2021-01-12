<?php

include "config.php";

class reposit {

    private $ip = SERVIDOR;
    private $user = USUARIO;
    private $pass = SENHA;
    private $database = BANCO;
    private $porta = PORTA;
    private $socket = SOCKET;

    function AbreConexao($banco) {
        switch ($banco) {
            case 'mysql':
            case 'sql':
                //if (!($this->sqlconnect = odbc_connect("DRIVER={SQL Server}; SERVER=$this->ip;DATABASE=$this->database;CHARSET=UTF-16", $this->user,$this->pass) ))
                //if (!($this->sqlconnect = odbc_connect("DRIVER={SQL Server}; SERVER=$this->ip;DATABASE=$this->database;Client_CSet=UTF-8;Server_CSet=Windows-1252", $this->user,$this->pass) ))
                if (!($this->sqlconnect = odbc_connect("DRIVER={SQL Server}; SERVER=$this->ip;DATABASE=$this->database;", $this->user, $this->pass) )) {
                    echo "<p>Conexão falhou !!!.</p>\n";
                    odbc_close();
                } else {
                    $ok = 1;
                    setlocale(LC_NUMERIC, "en_US");
                    setlocale(LC_COLLATE, "pt_BR");
                    setlocale(LC_TYPE, "pt_BR");
                    setlocale(LC_MONETARY, "pt_BR");
                    setlocale(LC_TIME, "pt_BR");
                    //setlocale(LC_ALL, "pt_BR");
                    //header('Content-type: text/html; charset=cp850');
                    //odbc_exec($this->sqlconnect, "SET NAMES 'UTF8'");
                    //odbc_exec($this->sqlconnect, "SET client_encoding='UTF-8'"); 
                }
            case 'oracle':
            case 'cache':
        }
        return;
    }

    function FechaConexao() {
        odbc_close();
        return;
    }

 // executa store procedure
 function Execprocedure($config)
 {
     $config = iconv('UTF-8', 'CP1252', $config);
     $this->AbreConexao("sql"); // Abrimos a conexão      
     $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
     $pstmt = odbc_prepare($this->sqlconnect, "{CALL " . $conf[0] . "}");
     $result = odbc_execute($pstmt, array());
     if ($result == false) {
         $pstmt = 0;
     }
     $this->FechaConexao(); // Fechamos a conexão
     return $pstmt;
 }

// Retorna todas as colunas
    function SelectAll($config) {

        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $conf[0] = $this->anti_injection($conf[0]);
        $sql = "select * from [Ntl]." . $conf[0] . " ";
        $result = odbc_exec($this->sqlconnect, $sql);

        /* $result=iconv("iso-8859-2","utf-8",odbc_fetch_array()); */
        $this->FechaConexao(); // Fechamos a conexão
        return $result;
    }

    // Retorna todas as colunas de acordo com uma condição
    function RunQuery($sql) {
        $sql = iconv('UTF-8', 'CP1252', $sql);
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $result = odbc_exec($this->sqlconnect, "" . $sql . "");
        $GLOBALS["rows"] = odbc_num_rows($result);

        $this->FechaConexao(); // Fechamos a conexão
        return $result; // aqui fica o retorno de todas as condicionais
    }

// Retorna todas as colunas
    function SelectAllJoinDistinct($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $conf[2] = $this->anti_injection($conf[2]);
        $sql = "SELECT distinct(" . $conf[3] . "),* FROM [Ntl]." . $conf[0] . " a ," . $conf[1] . " b WHERE " . $conf[2];
        $result = odbc_exec($this->sqlconnect, $sql);
//        if ($result == ""){
//            $result = 0;
//        }
        $this->FechaConexao(); // Fechamos a conexão
        return $result;
    }

// Retorna todas as colunas
    function SelectAllCampos($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $sql = "select " . $conf[1] . " FROM [Ntl]." . $conf[0] . " LIMIT $conf[2],$conf[3]";
        $result = odbc_exec($this->sqlconnect, $sql);
//        if ($result == ""){
//            $result = 0;
//        }
        $this->FechaConexao(); // Fechamos a conexão
        return $result;
    }

// Retorna colunas pre-fixadas
    function SelectCampos($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $sql = "select " . $conf[1] . " FROM [Ntl]." . $conf[0] . "";
        $result = odbc_exec($this->sqlconnect, $sql);
//        if ($result == ""){
//            $result = 0;
//        }
        $this->FechaConexao(); // Fechamos a conexão
        return $result;
    }

// Retorna colunas pre-fixadas com clausula WHERE
    function SelectCamposCond($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $conf[2] = $this->anti_injection($conf[2]);
        $sql = "SELECT " . $conf[1] . " FROM [Ntl]." . $conf[0] . " WHERE " . $conf[2];
        $result = odbc_exec($this->sqlconnect, $sql);
//        if ($result == ""){
//            $result = 0;
//        }
        $this->FechaConexao(); // Fechamos a conexão
        return $result;
    }

    // Retorna de acordo com as condições passadas
    function SelectCondTrue($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array

        $args = $conf[1];
        $args = $this->anti_injection($args);
        $sql = "SELECT * FROM [Ntl]." . $conf[0] . " WHERE " . $conf[1] . " ";
        $select = odbc_exec($this->sqlconnect, $sql);
        $result = odbc_num_rows($select);
        if ($result > 0) {
            $result = odbc_fetch_array($select);
        } else {
            $result = 0;
        }
        return $result; // aqui fica o retorno de todas as condicionais
    }

    function anti_injection($sql) {
        //return $sql;
        //$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\|--|\\\\)/", "", $sql);
        $sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|\|--|\\\\)/", "", $sql);
        $sql = trim($sql);
        return $sql;
    }

    // Retorna todas as colunas de acordo com uma condição
    function SelectCond($config) {

        $config = iconv('UTF-8', 'CP1252', $config);
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array 
        $conf[1] = $this->anti_injection($conf[1]);
        $sql = "SELECT * FROM [Ntl]." . $conf[0] . " WHERE " . $conf[1] . " ";
        $result = odbc_exec($this->sqlconnect, $sql);
        $this->FechaConexao(); // Fechamos a conexão
        return $result; // aqui fica o retorno de todas as condicionais
    }

    // Retorna todas as colunas de acordo com uma condição
    function TestaExiste($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array
        $conf[1] = $this->anti_injection($conf[1]);
        $sql = "SELECT * FROM [Ntl]." . $conf[0] . " WHERE " . $conf[1] . " ";
        $result = odbc_exec($this->sqlconnect, $sql);
//               $result =odbc_num_rows($result);
        $this->FechaConexao(); // Fechamos a conexão
        return $result; // aqui fica o retorno de todas as condicionais
    }

    // Retorna todas as colunas de acordo com uma condição
    function SelectCondJoin($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config);   // Aqui explodimos e jogamos em array 
        $conf[2] = $this->anti_injection($conf[2]);
        $sql = "SELECT * FROM [Ntl]." . $conf[0] . " a, [Ntl]." . $conf[1] . " b WHERE " . $conf[2] . " ";
        $result = odbc_exec($this->sqlconnect, $sql);
        $this->FechaConexao(); // Fechamos a conexão
        return $result; // aqui fica o retorno de todas as condicionais
    }

// faz update em uma tabela
    function Update($config) {
        $config = iconv('UTF-8', 'CP1252', $config);
        $listacampos = '';
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config); // Aqui explodimos e jogamos em array
        $listacampos = str_replace(";", ",", $conf[1]);
        if ($listacampos == '') {
            $listacampos = $conf[1];
        }
        // start da transação
        odbc_autocommit($this->sqlconnect, false);
        $listacampos = $this->anti_injection($listacampos);
        $conf[2] = $this->anti_injection($conf[2]);
        try {
            $sql = "update " . $conf[0] . " set " . $listacampos . " WHERE " . $conf[2] . " ";
            $select = odbc_exec($this->sqlconnect, $sql);
            $result = odbc_num_rows($select);
            if ($select == false) {
                $result = 0;
            }
        } catch (Exception $e) {
            odbc_rollback($this->sqlconnect);
        }
        odbc_commit($this->sqlconnect);
        $this->FechaConexao(); // Fechamos a conexão
        return $result; // aqui fica o retorno de todas as condicionais
    }

    // faz insert em uma tabela
    function Insert($config) {
        $config = iconv('UTF-8', 'CP1252', $config);
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config); // Aqui explodimos e jogamos em array
        $listacampos = $conf[1];
        $listavalores = $conf[2];
        $listacampos = $this->anti_injection($listacampos);
        $conf[2] = $this->anti_injection($conf[2]);
        // start da transação
        odbc_autocommit($this->sqlconnect, false);
        try {
            $sql = "insert into [Ntl]." . $conf[0] . "(" . $listacampos . ") values(" . $conf[2] . ") ";
            $select = odbc_exec($this->sqlconnect, $sql);
            $result = odbc_num_rows($select);
            $newid = odbc_exec($this->sqlconnect, "select @@identity");
            if ($select == false) {
                $result = 0;
                $newid = 0;
            }
            $GLOBALS['NEWID'] = $newid;
        } catch (Exception $e) {
            odbc_rollback($this->sqlconnect);
        }

        odbc_commit($this->sqlconnect);

        $this->FechaConexao(); // Fechamos a conexão
        if ($newid > 0) {
            $result = 1;
        }
        return $result; // aqui fica o retorno de todas as condicionais
    }

    // faz delete em uma tabela
    function Delete($config) {
        $this->AbreConexao("sql"); // Abrimos a conexão      
        $conf = explode("|", $config); // Aqui explodimos e jogamos em array
        $conf[1] = $this->anti_injection($conf[1]);
        $sql = "delete from [Ntl]." . $conf[0] . " WHERE " . $conf[1] . " ";
        $select = odbc_exec($this->sqlconnect, $sql);
        $result = odbc_num_rows($select);
        $this->FechaConexao(); // Fechamos a conexão               
        return $result; // aqui fica o retorno de linhas afetadas
    }

    function PossuiPermissao($config) {
        session_start();
        $usuario = $_SESSION['login'];
        $conf = explode("|", $config); // Aqui explodimos e jogamos em array

        $possuiPermissao = 0;
        $result = $this->SelectCondTrue("usuario| login='" . $usuario . "' and ativo=1");
        if ($row = $result) {
            $codigoUsuario = $row['codigo'];
            $tipoUsuario = $row['tipoUsuario'];

            if ($tipoUsuario === "C") {
                $sql = "SELECT F.CODIGO FROM Ntl.funcionalidade F WHERE (f.nome = '" . $conf[0] . "' OR f.nome = '" . $conf[1] . "') ";
                $sql = $sql . " EXCEPT ";
                $sql = $sql . " SELECT usuf.funcionalidade FROM Ntl.usuarioFuncionalidade usuf INNER JOIN Ntl.funcionalidade faux on faux.codigo = usuf.funcionalidade ";
                $sql = $sql . " AND (faux.nome = '" . $conf[0] . "' OR faux.nome = '" . $conf[1] . "') ";
                $sql = $sql . " WHERE usuf.usuario=" . $codigoUsuario . " ";

                $result = $this->RunQuery($sql);
                if ($GLOBALS["rows"] === 0) {
                    $possuiPermissao = 1;
                }
            }
            if ($tipoUsuario === "S") {
                $possuiPermissao = 1;
            }
        }
        return $possuiPermissao;
    }

    function RetornaCodigoUsuarioLogado() {
        session_start();
        $usuario = $_SESSION['login'];
        $conf = explode("|", $config); // Aqui explodimos e jogamos em array

        $codigoUsuarioLogado = 0;
        $result = $this->SelectCondTrue("usuario| login = '" . $usuario . "' AND ativo = 1");
        if ($row = $result) {
            $codigoUsuarioLogado = +$row['codigo'];
        }
        return $codigoUsuarioLogado;
    }
}
