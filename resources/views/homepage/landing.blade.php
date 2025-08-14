<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home Page</title>
  <link rel="icon" href="/images/DIDM_Logo.png" type="image/x-icon" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center relative">

  <!-- Admin Page Link -->
  <div class="absolute top-4 right-6">
    <a href="{{ route('admin.page') }}" class="text-blue-600 font-medium hover:underline">Go to Admin Page</a>
  </div>


  <!-- Form Card -->
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md mt-12">

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
  
    <h1 class="text-2xl font-bold text-center text-blue-800 mb-6">Appointment Form</h1>

    <form method="POST" action="{{ route('appointment.store') }}" class="space-y-4">
      @csrf

      <!-- Full Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input
          type="text"
          name="fullname"
          required
          placeholder="Enter your name"
          class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2 border focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      <!-- Contact Number -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input
          type="tel"
          name="number"
          required
          placeholder="e.g. 09123456789"
          class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2 border focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

     <!-- Appointment Date -->
<div>
    <label class="block text-sm font-medium text-gray-700">Appointment Date</label>
    <input
      type="date"
      name="date"
      id="date"
      required
      class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2 border focus:ring-blue-500 focus:border-blue-500"
    />
  </div>
  
  <!-- Appointment Time -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Appointment Time</label>
    <input
      type="time"
      name="time"
      id="time"
      min="08:00"
      max="23:59"
      required
      class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2 border focus:ring-blue-500 focus:border-blue-500"
    />
  </div>

      <!-- Submit Button -->
      <div class="pt-4">
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300"
        >
          Submit Appointment
        </button>
      </div>
    </form>
  </div>

  <script>
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('time');
  
    const today = new Date();
    const maxDate = new Date(today);
    maxDate.setDate(today.getDate() + 2);
  
    const formatDate = (d) => d.toISOString().split('T')[0];
  
    // Apply date constraints
    dateInput.min = formatDate(today);
    dateInput.max = formatDate(maxDate);
  
    // Ensure time is always enabled
    timeInput.disabled = false;
  </script>
  

</body>
</html>
