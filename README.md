# Owly Courses API

## Descrizione del Progetto

Questo progetto è un'implementazione di un'API RESTful per la gestione di corsi cross-funzionali progettati per stimolare la curiosità dei più piccoli. L'API permette l'inserimento, la modifica, la cancellazione e il filtraggio di corsi e materie. Il progetto è basato su PHP, utilizza MySQL come database e PDO per la prevenzione di attacchi SQL Injection.



## Funzionalità Principali

- **Gestione delle Materie**: Inserimento, modifica e cancellazione di materie (caratterizzate dal solo nome).
- **Gestione dei Corsi**: Inserimento, modifica e cancellazione di corsi, con specifica del nome, delle materie correlate e dei posti disponibili.
- **Filtraggio dei Corsi**: Possibilità di visualizzare e filtrare i corsi in base al nome, alle materie e ai posti disponibili.

## Endpoint API

### Materie

- **Aggiungere una materia**  
  - **Metodo:** `POST`
  - **Endpoint:** `/api/subjects.php`
  - **Body (JSON):**  
    ```json
    { "name": "Nome della materia" }
    ```

- **Modificare una materia**  
  - **Metodo:** `PUT`
  - **Endpoint:** `/api/subjects.php`
  - **Body (JSON):**  
    ```json
    { "id": 1, "name": "Nome modificato" }
    ```

- **Cancellare una materia**  
  - **Metodo:** `DELETE`
  - **Endpoint:** `/api/subjects.php`
  - **Body (JSON):**  
    ```json
    { "id": 1 }
    ```

### Corsi

- **Aggiungere un corso**  
  - **Metodo:** `POST`
  - **Endpoint:** `/api/courses.php`
  - **Body (JSON):**  
    ```json
    { 
      "name": "Nome del corso", 
      "available_slots": 10, 
      "subjects": [1, 2] 
    }
    ```

- **Modificare un corso**  
  - **Metodo:** `PUT`
  - **Endpoint:** `/api/courses.php`
  - **Body (JSON):**  
    ```json
    { 
      "id": 1,
      "name": "Nome modificato", 
      "available_slots": 15, 
      "subjects": [1, 3] 
    }
    ```

- **Cancellare un corso**  
  - **Metodo:** `DELETE`
  - **Endpoint:** `/api/courses.php`
  - **Body (JSON):**  
    ```json
    { "id": 1 }
    ```

- **Visualizzare e filtrare i corsi**  
  - **Metodo:** `GET`
  - **Endpoint:** `/api/courses.php`
  - **Parametri di filtro (facoltativi):**  
    - `name`: Nome del corso (es. `?name=Scienze`)
    - `subject`: Nome della materia (es. `?subject=Matematica`)
    - `available_slots`: Numero di posti disponibili (es. `?available_slots=10`)

## Requisiti Tecnici

- **PHP** 7.0 o superiore
- **MySQL** 5.7 o superiore
- **PDO** per la gestione delle query al database
- **Postman** o **cURL** per testare le API

## Installazione

1. Clona il repository:

   ```bash
   git clone https://github.com/tuo-username/owly-courses-api.git
   cd owly-courses-api
   ```

2. Importa la struttura del database eseguendo lo script migrations.sql in MySQL:
   
   ```bash
   mysql -u username -p database_name < migrations.sql
   ```

3. Configura il tuo file di connessione al database in config/database.php.
   
4. Avvia il server PHP integrato o configura un server locale (es. Apache):

   ```bash
   php -S localhost:8000
   ```

5. Testa le API utilizzando strumenti come Postman o cURL.
   
