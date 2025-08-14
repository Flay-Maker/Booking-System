<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Booking</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <form method="POST" action="{{ route('booking.update', $booking->id) }}" class="bg-white p-6 rounded shadow-md w-full max-w-md">
    @csrf
    @method('PUT')
    <h1 class="text-xl font-bold mb-4">Edit Booking</h1>

    <label class="block mb-2">Full Name</label>
    <input type="text" name="fullname" value="{{ $booking->fullname }}" class="w-full border px-3 py-2 mb-4" required>

    <label class="block mb-2">Contact Number</label>
    <input type="text" name="number" value="{{ $booking->number }}" class="w-full border px-3 py-2 mb-4" required>

    <label class="block mb-2">Date & Time</label>
    <input type="datetime-local" name="dateandtime" value="{{ \Carbon\Carbon::parse($booking->dateandtime)->format('Y-m-d\TH:i') }}" class="w-full border px-3 py-2 mb-4" required>

    <label class="block mb-2">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4">
      <option {{ $booking->status === 'Pending' ? 'selected' : '' }}>Pending</option>
      <option {{ $booking->status === 'Completed' ? 'selected' : '' }}>Completed</option>
      <option {{ $booking->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
  </form>

</body>
</html>
