<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Booking Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 relative">

  <!-- Top Navigation -->


  
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-blue-700">Bookings Management</h1>

    <!-- Go to User Page Link -->
<div class="mb-4">
    <a href="{{ route('appointment.form') }}" class="text-blue-600 font-medium hover:underline">
      ← Back to User Page
    </a>
  </div>
  
    <button onclick="openCreateModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      + New Booking
    </button>
  </div>

  <!-- Search Bar -->
<div class="mb-4">
    <input
      type="text"
      id="searchInput"
      placeholder="Search bookings..."
      class="w-full max-w-xs border border-gray-300 rounded px-3 py-2 shadow-sm"
    />
  </div>


  <!-- Booking Table -->
  <div class="bg-white rounded shadow overflow-x-auto">
    @if ($errors->any())
  <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
    <ul class="list-disc list-inside text-sm">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session('success'))
  <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
    {{ session('success') }}
  </div>
@endif

    <table class="w-full table-auto text-left border">
      <thead class="bg-blue-600 text-white">
        <tr>
          <th class="px-4 py-2 border">Full Name</th>
          <th class="px-4 py-2 border">Number</th>
          <th class="px-4 py-2 border">Date</th>
          <th class="px-4 py-2 border">Time</th>
          <th class="px-4 py-2 border">Status</th>
          <th class="px-4 py-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bookings as $booking)
          <tr class="border-t">
            <td class="px-4 py-2 border">{{ $booking->fullname }}</td>
            <td class="px-4 py-2 border">{{ $booking->number }}</td>
            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($booking->date)->format('F j, Y') }}</td>
            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</td>
            <td class="px-4 py-2 border">{{ $booking->status }}</td>
            <td class="px-4 py-2 border">
              <button 
                onclick='openEditModal(@json($booking))'
                class="text-blue-600 hover:underline mr-2">
                Edit
              </button>

              <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No bookings found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    
    <div class="bg-white p-6 rounded-lg w-full max-w-md relative shadow-lg">
      <button onclick="closeEditModal()" class="absolute top-2 right-3 text-gray-500 text-xl font-bold">&times;</button>
      
      <form id="editForm" method="POST">
        @csrf
        @method('PUT')

        <h2 class="text-xl font-semibold text-blue-700 mb-4">Edit Booking</h2>

        <input type="hidden" id="editId">

        <label class="block text-sm font-medium mb-1">Full Name</label>
        <input type="text" name="fullname" id="editFullname" required class="w-full border px-3 py-2 rounded mb-3">

        <label class="block text-sm font-medium mb-1">Contact Number</label>
        <input type="text" name="number" id="editNumber" required class="w-full border px-3 py-2 rounded mb-3">

       <!-- Appointment Date -->
<input
type="date"
name="date"
id="editDate"
required
class="w-full border px-3 py-2 rounded mb-3"
/>

<!-- Appointment Time -->
<input
type="time" 
name="time"
id="editTime"
min="08:00"
max="23:59"
required
class="w-full border px-3 py-2 rounded mb-3"
/>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" id="editStatus" class="w-full border px-3 py-2 rounded mb-4">
          <option value="Pending">Pending</option>
          <option value="Completed">Completed</option>
          <option value="Cancelled">Cancelled</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Update Booking
        </button>
      </form>
    </div>
  </div>

  <!-- Create Booking Modal -->
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md relative shadow-lg">
      <button onclick="closeCreateModal()" class="absolute top-2 right-3 text-gray-500 text-xl font-bold">&times;</button>
  
      <form id="createForm" method="POST" action="{{ route('appointment.admin.store') }}">
        @csrf
        <h2 class="text-xl font-semibold text-blue-700 mb-4">New Booking</h2>
  
        <label class="block text-sm font-medium mb-1">Full Name</label>
        <input type="text" name="fullname" required class="w-full border px-3 py-2 rounded mb-3">
  
        <label class="block text-sm font-medium mb-1">Contact Number</label>
        <input type="text" name="number" required class="w-full border px-3 py-2 rounded mb-3">
  
        <label class="block text-sm font-medium mb-1">Appointment Date</label>
       <!-- Appointment Date -->
<input
type="date"
name="date"
id="createDate"
required
class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2"
/>

<!-- Appointment Time -->
<input
type="time"
name="time"
id="createTime"
min="08:00"
max="23:59"
required
class="w-full border px-3 py-2 rounded mb-3"
/>
  
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Submit Booking
        </button>
      </form>
    </div>
  </div>

  <!-- Modal Script -->
  <script>
    // === Edit Modal Function ===
    function openEditModal(booking) {
      const modal = document.getElementById('editModal');
      modal.classList.remove('hidden');
  
      // Fill fields
      document.getElementById('editFullname').value = booking.fullname;
      document.getElementById('editNumber').value = booking.number;
  
      // Format date for input type="date"
      const formattedDate = new Date(booking.date).toISOString().split('T')[0];
      document.getElementById('editDate').value = formattedDate;
  
      // Format time to HH:mm from HH:mm:ss
      const timeParts = booking.time.split(':'); // Ex: ["14", "00", "00"]
      const formattedTime = `${timeParts[0]}:${timeParts[1]}`;
      document.getElementById('editTime').value = formattedTime;
  
      document.getElementById('editStatus').value = booking.status;
  
      // Set form action
      const form = document.getElementById('editForm');
      form.action = `/booking/${booking.id}`;
    }
  
    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }
  
    function openCreateModal() {
      document.getElementById('createModal').classList.remove('hidden');
    }
  
    function closeCreateModal() {
      document.getElementById('createModal').classList.add('hidden');
    }
  
    // === Apply constraints to date inputs ===
    function setDateConstraints(dateId) {
      const dateInput = document.getElementById(dateId);
      const today = new Date();
      const maxDate = new Date();
      maxDate.setDate(today.getDate() + 2);
  
      const formatDate = (date) => date.toISOString().split('T')[0];
  
      dateInput.min = formatDate(today);
      dateInput.max = formatDate(maxDate);
    }
  
    // Apply constraints (date only) to both modals
    setDateConstraints('createDate');
    setDateConstraints('editDate');
  
    // === Search Filter ===
    document.getElementById('searchInput').addEventListener('input', function () {
      const searchText = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');
  
      rows.forEach((row) => {
        const cellsText = row.textContent.toLowerCase();
        row.style.display = cellsText.includes(searchText) ? '' : 'none';
      });
    });
  </script>
  

</body>
</html>
