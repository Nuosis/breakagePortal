<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lookup Breakage</title>
</head>
<body style="background-color: #f7fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;">
    <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Look up a Student's iPad Damage History</h2>
        <form action="/lookup" method="post" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="student_id" style="display: block; color: #4a5568;">Student ID</label>
                <input type="text" id="student_id" name="student_id" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
            </div>
            <button type="submit" style="width: 100%; padding: 0.5rem; background-color: rgba(72, 151, 222, 0.85); color: white; font-weight: 600; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border: none; cursor: pointer; transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                FIND
            </button>
        </form>
    </div>
</body>
</html>
