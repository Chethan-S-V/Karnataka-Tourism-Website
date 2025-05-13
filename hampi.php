<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticket Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(#89f7fe, #66a6ff);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 350px;
      text-align: center;
    }
    input, select, button {
      width: 100%;
      padding: 12px;
      margin-top: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background: #28a745;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Book Your Ticket</h1>
    <form action="hampi-ticket.php" method="POST" onsubmit="return confirm('Confirm booking?');">
      <input type="text" name="name" placeholder="Enter your Name" pattern="[A-Za-z\s]+" required>
      <input type="text" name="tour" value="Hampi" readonly>
      <input type="text" name="validation_date" value="10-04-2025" readonly>
      <select name="seat_type" required>
        <option value="Sleeper AC">Sleeper AC</option>
      </select>
      <input type="text" name="validation_time" value="10:00 PM" readonly>
      <button type="submit">Book Now</button>
    </form>
  </div>
</body>
</html>
