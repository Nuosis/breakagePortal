<!-- resources/views/submit.blade.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Submit Breakage</title>
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  </head>
  <body style="background-color: #f7fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;">
      <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Submit Breakage Report and Create Work Order</h2>
          <form action="/submit" method="post" style="display: flex; flex-direction: column; gap: 1rem;">
              @csrf
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="student_id" style="display: block; color: #4a5568;">Student ID</label>
                  <input type="text" id="student_id" name="student_id" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
              </div>
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="fa" style="display: block; color: #4a5568;">FA#</label>
                  <input type="text" id="fa" name="fa" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
              </div>
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="school" style="display: block; color: #4a5568;">School</label>
                  <select id="school" name="school" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                      <!-- Options -->
                  </select>
              </div>
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="damage_type" style="display: block; color: #4a5568;">Type of damage</label>
                  <select id="damage_type" name="damage_type" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                      <option value="accident">Accident</option>
                      <option value="intentional">Intentional</option>
                      <option value="lost">Lost/Stolen</option>
                  </select>
              </div>
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="equipment" style="display: block; color: #4a5568;">Equipment Damaged</label>
                  <select id="equipment" name="equipment" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                      <option value="ipad">iPad</option>
                      <option value="case">Case</option>
                      <option value="ipad_keyboard">iPad + Keyboard</option>
                  </select>
              </div>
              <div class="form-group" style="margin-bottom: 1rem;">
                  <label for="notes" style="display: block; color: #4a5568;">Notes</label>
                  <textarea id="notes" name="notes" style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"></textarea>
              </div>
              <button type="submit" style="width: 100%; padding: 0.5rem; background-color: #4c51bf; color: white; font-weight: 600; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border: none; cursor: pointer; transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                  SUBMIT
              </button>
          </form>
      </div>
  </body>
</html>
