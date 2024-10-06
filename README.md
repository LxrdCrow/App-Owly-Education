# App-Owly-Education

## Descrizione del Progetto

Questo progetto è un'implementazione di un'API RESTful per la gestione di corsi cross-funzionali progettati per stimolare la curiosità dei più piccoli. L'API consente l'inserimento, la modifica, la cancellazione e la visualizzazione di corsi e materie, utilizzando **PHP** con **MySQL** e **PDO** per la gestione del database e la prevenzione di attacchi SQL Injection. Include anche l'utilizzo di **modelli** e **controller** per organizzare meglio il codice seguendo l'architettura MVC.

## Funzionalità Principali

- **Gestione delle Materie**: Inserimento, modifica e cancellazione delle materie, che includono un semplice nome.
- **Gestione dei Corsi**: Inserimento, modifica e cancellazione di corsi, con specifica del nome, delle materie correlate e dei posti disponibili.
- **Visualizzazione e Filtraggio dei Corsi**: Possibilità di visualizzare e filtrare i corsi in base a nome, materie e numero di posti disponibili.
- **Relazione Corsi-Materie**: È stata implementata una tabella di relazione che collega i corsi con le materie.

## Struttura del Progetto

- **Controllers**: I controller gestiscono la logica per le operazioni CRUD sui corsi e le materie.
- **Models**: I modelli rappresentano i dati del database e contengono metodi per interagire con esso.
- **Routes**: L'applicazione utilizza un router per smistare le richieste API alle azioni appropriate nei controller.

## Endpoint API

### Materie

- **Aggiungere una materia**  
  - **Metodo:** `POST`
  - **Endpoint:** `/subjects`
  - **Body (JSON):**  
    ```json
    { "name": "Nome della materia" }
    ```

- **Modificare una materia**  
  - **Metodo:** `PUT`
  - **Endpoint:** `/subjects/{id}`
  - **Body (JSON):**  
    ```json
    { "name": "Nome modificato" }
    ```

- **Cancellare una materia**  
  - **Metodo:** `DELETE`
  - **Endpoint:** `/subjects/{id}`

### Corsi

- **Aggiungere un corso**  
  - **Metodo:** `POST`
  - **Endpoint:** `/courses`
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
  - **Endpoint:** `/courses/{id}`
  - **Body (JSON):**  
    ```json
    { 
      "name": "Nome modificato", 
      "available_slots": 15, 
      "subjects": [1, 3] 
    }
    ```

- **Cancellare un corso**  
  - **Metodo:** `DELETE`
  - **Endpoint:** `/courses/{id}`

- **Visualizzare e filtrare i corsi**  
  - **Metodo:** `GET`
  - **Endpoint:** `/courses`
  - **Parametri di filtro (facoltativi):**  
    - `name`: Nome del corso (es. `?name=Scienze`)
    - `subject`: ID della materia (es. `?subject=1`)
    - `available_slots`: Numero di posti disponibili (es. `?available_slots=10`)

## Requisiti Tecnici

- **PHP** 7.0 o superiore
- **MySQL** 5.7 o superiore
- **PDO** per la gestione delle query al database
- **Postman** o **cURL** per testare le API
- **Composer** per la gestione delle dipendenze

## Installazione

1. Clona il repository:

   ```bash
   git clone https://github.com/LxrdCrow/App-Owly-Education.git
   cd App-Owly-Education
   ```

2. Installa le dipendenze PHP tramite Composer:

   ```bash
   composer install
   ```

3. Crea il database e importa lo schema:

   ```bash
   mysql -u username -p database_name < migrations.sql
   ```

4. Configura il file `.env` con le credenziali del database:

   ```env
   DB_HOST=localhost
   DB_NAME=owly_learning
   DB_USER=your_username
   DB_PASS=your_password
   ```

5. Avvia il server PHP:

   ```bash
   php -S localhost:8000
   ```

6. Testa le API utilizzando strumenti come Postman o cURL.

## Struttura del Database

- **Subjects**: Tabella per la gestione delle materie (id, name)
- **Courses**: Tabella per la gestione dei corsi (id, name, available_slots)
- **Course_Subject**: Tabella di relazione tra corsi e materie (course_id, subject_id)


   
