# Blood-Flow-Web
Complete Blood Donation Management System

A full-stack **Blood Donation Management System** built with  MySQL, HTML, CSS and JavaScript. The system simplifies blood donation, donor management, blood requests, hospital coordination, and inventory tracking through separate dashboards for different users.

---

## 📌 Features

### 👤 User Features
- User Registration & Login
- Search Blood Donors
- Request Blood
- View Request History
- Profile Management
- Secure Authentication

### 🩸 Donor Features
- Donor Registration
- Update Availability
- Manage Personal Profile
- View Donation History
- Accept Blood Requests

### 🏥 Hospital Features
- Hospital Dashboard
- Manage Blood Requests
- View Available Donors
- Blood Inventory Monitoring

### 👨‍💼 Admin Features
- Secure Admin Login
- Manage Users
- Manage Donors
- Manage Hospitals
- Approve Blood Requests
- Blood Inventory Management
- Dashboard Analytics

---

# 🛠️ Tech Stack

### Frontend
- HTML5
- CSS3
- Bootstrap
- JavaScript

### Backend
- Node.js
- Express.js

### Database
- MySQL

### Authentication
- Express Session
- Cookie Parser
- Password Hashing

---

# 📂 Project Structure

```
BloodFlow/
│
├── routes/
├── controllers/
├── models/
├── middleware/
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── views/
├── database/
│   └── bloodflow.sql
├── app.js
├── package.json
└── README.md
```

---

# ⚙️ Installation

## 1. Clone the Repository

```bash
git clone https://github.com/yourusername/BloodFlow.git
```

```bash
cd BloodFlow
```

---

## 2. Install Dependencies

```bash
npm install
```

---

## 3. Create MySQL Database

Create a database named:

```sql
bloodflow
```

Import the SQL file:

```sql
database/bloodflow.sql
```

---

## 4. Configure Environment Variables

Create a `.env` file in the root directory.

```env
PORT=3000

DB_HOST=localhost
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=bloodflow

SESSION_SECRET=your_secret_key
```

---

## 5. Run the Server

```bash
npm start
```

or

```bash
node app.js
```

The application will be available at:

```
http://localhost:3000
```

---

# 🗄️ Database

The project uses **MySQL** with multiple relational tables including:

- Users
- Donors
- Hospitals
- Admin
- Blood Requests
- Blood Inventory
- Donations
- Blood Groups

Relationships are maintained using **Primary Keys** and **Foreign Keys**.

---

# 🔒 Security Features

- Password Hashing
- Session-Based Authentication
- Role-Based Access Control
- Input Validation
- SQL Injection Protection
- Secure Login System

---

# 📈 Future Improvements

- Email Notifications
- SMS Alerts
- Blood Request Tracking
- Google Maps Integration
- Real-Time Notifications
- REST API
- Mobile Application
- JWT Authentication

---

# 📷 Screenshots

Add your screenshots here.

```
screenshots/
├── home.png
├── login.png
├── dashboard.png
├── donor.png
└── admin.png
```

---

# 👨‍💻 Author

**Tasin Shanto**
