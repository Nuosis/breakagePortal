<!-- resources/views/lookup-results.blade.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Breakage Results</title>
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  </head>
  <body style="background-color: #f7fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;">
    <div style="display: flex; flex-direction: column; ">
      <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          @if(isset($breakageData['response']['data']) && is_array($breakageData['response']['data']) && $breakageData['messages'][0]['code'] == 0)
          <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Breakage Data for: {{ $breakageData['response']['data'][0]['fieldData']['StudentFirstName'] }} {{ $breakageData['response']['data'][0]['fieldData']['StudentLastName'] }}</h2>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; table-layout: auto;">
              <thead>
                  <tr>
                      <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Type</th>
                      <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Equipment</th>
                      <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: right;">Cost</th>
                      <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left; width: 100%;">Notes</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($breakageData['response']['data'] as $breakage)
                      <tr>
                          <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['Incident'] }}</td>
                          <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['Hardware'] }}</td>
                          <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem; text-align: right;">
                              {{ '$' . number_format($breakage['fieldData']['Cost'], 2) }}
                          </td>
                          <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem; width: 100%;">{{ $breakage['fieldData']['Notes'] }}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          @else
            <p>No breakage data found for this student</p>
          @endif
      </div>
      <div style="background-color: white; padding: 2rem; margin-top: 1.5rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Submit Breakage Report and Create Work Order</h2>
        <form action="/submit" method="post" style="display: flex; flex-direction: column; gap: 1rem; max-width: 600px; margin: 0 auto;">
          @csrf
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="student_id" style="display: block; color: #4a5568; font-size: 1rem;">Student ID</label>
              <input type="text" id="student_id" name="student_id" value="{{ request()->input('student_id') }}" readonly style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem;">
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="fa" style="display: block; color: #4a5568; font-size: 1rem;">FA#</label>
              <input type="text" id="fa" name="fa" required style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem;">
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="school" style="display: block; color: #4a5568; font-size: 1rem;">School</label>
              <select id="school" name="school" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                  <option value="" disabled selected>Select option</option>
                  <!-- Add your options here -->
              </select>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="damage_type" style="display: block; color: #4a5568; font-size: 1rem;">Type of damage</label>
              <select id="damage_type" name="damage_type" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                  <option value="" disabled selected>Select option</option>
                  <option value="accident">Accident</option>
                  <option value="intentional">Intentional</option>
                  <option value="lost">Lost/Stolen</option>
              </select>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="equipment" style="display: block; color: #4a5568; font-size: 1rem;">Equipment Damaged</label>
              <select id="equipment" name="equipment" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                  <option value="" disabled selected>Select option</option>
                  <option value="ipad">iPad</option>
                  <option value="case">Case</option>
                  <option value="ipad_keyboard">iPad + Keyboard</option>
              </select>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="notes" style="display: block; color: #4a5568; font-size: 1rem;">Notes</label>
              <textarea id="notes" name="notes" style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; min-height: 2.5rem;"></textarea>
          </div>
          <button type="submit" style="width: 100%; padding: 0.75rem; background-color: #4c51bf; color: white; font-weight: 600; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border: none; cursor: pointer; transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
              SUBMIT
          </button>
        </form>
      
      </div>
    </div>
  </body>
</html>
