<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Lookup Breakage</title>
      <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="bg-gray-100 flex items-center justify-center min-h-screen">
      <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
          <h2 class="text-2xl font-bold mb-6 text-gray-800">Look up a Student's iPad Damage History</h2>
          <form action="/lookup" method="post" class="space-y-6">
              @csrf
              <div>
                  <label for="student_id" class="block text-gray-700">Student ID</label>
                  <input type="text" id="student_id" name="student_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-indigo-300 focus:border-indigo-300">
              </div>
              <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-75">
                  FIND
              </button>
          </form>
      </div>
  </body>
</html>
