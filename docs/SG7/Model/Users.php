===================
= SG7_Model_Users =
===================

Třída: SG7_Model_Users
Předek: SG7_Db_Table_Abstract

Třída je připravená pro použití jako reprezentace tabulky uživatelů.
Implementuje metody pro ověřování uživatelů, přihlašování, odhlašování a nastavuje typ řádku na řádek uživatele

Vlastnosti
==========

#_loginColumn string
--------------------

Obsahuje sloupec s uživatelským (přihlašovacím) jménem uživatele

#_passwordColumn string
-----------------------

Obsahuje jméno sloupce s heslem

Metody
======

+signIn($username, $password)
-----------------------------

pokusí se přihlásit uživatele dle jména a hesla

#_onSigned($userRow)
--------------------

Je volána po tom, co byl uživatel úspěšně přihlášen. 
@param $userRow obsahuje řádek příslušného uživatele
V základu metoda nic nedělá. Je určena pro třídu, která dědí
