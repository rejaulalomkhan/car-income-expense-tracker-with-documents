# Car Expense Tracker Database ER Diagram

```mermaid
erDiagram
    USERS {
        int id PK
        string name
        string email
        string password
        ...
    }
    CARS {
        int id PK
        string name
        string plate_number
        string model
        int year
        string color
        string photo
        enum status
        ...
    }
    INCOMES {
        int id PK
        int car_id FK
        decimal amount
        string source
        date date
        text description
        ...
    }
    EXPENSES {
        int id PK
        int car_id FK
        decimal amount
        string category
        date date
        text description
        ...
    }
    CAR_DOCUMENTS {
        int id PK
        int car_id FK
        enum document_type
        date document_expiry_date
        string document_image
        string document_comment
        ...
    }
    DOCUMENT_TYPES {
        int id PK
        string name
        text description
        bool is_active
        ...
    }
    COMPANY_DOCUMENTS {
        int id PK
        int document_type_id FK
        string title
        date issue_date
        date expiry_date
        string document_file
        text description
        bool is_active
        ...
    }
    SETTINGS {
        int id PK
        string key
        text value
        ...
    }
    NOTIFICATIONS {
        uuid id PK
        string type
        int notifiable_id
        string notifiable_type
        text data
        timestamp read_at
        ...
    }

    CARS ||--o{ INCOMES : has
    CARS ||--o{ EXPENSES : has
    CARS ||--o{ CAR_DOCUMENTS : has
    DOCUMENT_TYPES ||--o{ COMPANY_DOCUMENTS : has
```

---

- `PK` = Primary Key
- `FK` = Foreign Key
- `...` = Other fields
- Each car can have many incomes, expenses, and documents.
- Each document type can have many company documents. 