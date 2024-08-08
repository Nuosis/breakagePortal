<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Breakage Results</title>
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  </head>
  <?php
    $studentData=$breakageData['studentData'];
    $breakageData=$breakageData['breakageData'];
  ?>
  <body style="background-color: #f7fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;">
    <div style="display: flex; flex-direction: column; ">
      <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          @if(isset($studentData['response']['data']) && is_array($studentData['response']['data']) && (int)$studentData['messages'][0]['code'] === 0)
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Breakage Data for: {{ $studentData['response']['data'][0]['fieldData']['First'] }} {{ $studentData['response']['data'][0]['fieldData']['Last'] }}</h2>
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
        <form action="{{ url('/submit') }}" method="post" style="display: flex; flex-direction: column; gap: 1rem; max-width: 600px; margin: 0 auto;">
          @csrf
          @if(isset($error))
              <div style="color: red; margin-bottom: 1rem;">{{ $error }}</div>
          @endif
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="student_id" style="display: block; color: #4a5568; font-size: 1rem;">Student ID</label>
              <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $submittedData['student_id'] ?? request()->input('student_id')) }}" readonly style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem;">
          </div>
          <input type="hidden" name="student_first_name" value="{{ old('student_first_name', $submittedData['student_first_name'] ?? $studentData['response']['data'][0]['fieldData']['First']) }}">
          <input type="hidden" name="student_last_name" value="{{ old('student_last_name', $submittedData['student_last_name'] ?? $studentData['response']['data'][0]['fieldData']['Last']) }}">
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="fa" style="display: block; color: #4a5568; font-size: 1rem;">FA#</label>
              <input type="text" id="fa" name="fa" required value="{{ old('fa', $submittedData['fa'] ?? '') }}" style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem;">
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
            <label for="school" style="display: block; color: #4a5568; font-size: 1rem;">School</label>
            @if(isset($studentData['response']['data']) && is_array($studentData['response']['data']) && (int)$studentData['messages'][0]['code'] === 0)
                <input type="text" id="school" name="school" value="{{ old('school', $studentData['response']['data'][0]['fieldData']['School']) }}" readonly style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);" />
                <input type="hidden" name="siteNo" value="{{ old('siteNo', $studentData['response']['data'][0]['fieldData']['SiteNo']) }}" />
            @else
                <select id="school" name="school" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                    <option value="" disabled selected>Select Site</option>
                    @foreach($sites['response']['data'] as $site)
                        <option value="{{ $site['fieldData']['Site'] }}" 
                            @if(old('school', $submittedData['school'] ?? '') == $site['fieldData']['Site']) 
                                selected 
                            @endif
                        >
                            {{ $site['fieldData']['Site'] }}
                        </option>
                    @endforeach
                </select>
            @endif
          </div>       
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="damage_type" style="display: block; color: #4a5568; font-size: 1rem;">Type of damage</label>
              <select id="damage_type" name="damage_type" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                  <option value="" disabled selected>Select Option</option>
                  <option value="Accident" @if(old('damage_type', $submittedData['damage_type'] ?? '') == 'Accident') selected @endif>Accident</option>
                  <option value="Intentional" @if(old('damage_type', $submittedData['damage_type'] ?? '') == 'Intentional') selected @endif>Intentional</option>
                  <option value="Lost/Stolen" @if(old('damage_type', $submittedData['damage_type'] ?? '') == 'Lost/Stolen') selected @endif>Lost/Stolen</option>
              </select>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
            <label for="equipment" style="display: block; color: #4a5568; font-size: 1rem;">Equipment Damaged</label>
            <select id="equipment" name="equipment" required style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; height: calc(1.5em + 0.75rem + 2px);">
                <option value="" disabled selected>Select Option</option>
                <option value="iPad" @if(old('equipment', $submittedData['equipment'] ?? '') == 'iPad') selected @endif>iPad</option>
                <option value="Keyboard Case" @if(old('equipment', $submittedData['equipment'] ?? '') == 'Keyboard Case') selected @endif>Keyboard Case</option>
                <option value="iPad + Keyboard Case" @if(old('equipment', $submittedData['equipment'] ?? '') == 'iPad + Keyboard Case') selected @endif>iPad + Keyboard Case</option>
            </select>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
              <label for="notes" style="display: block; color: #4a5568; font-size: 1rem;">Notes</label>
              <textarea id="notes" name="notes" style="margin-top: 0.25rem; display: block; width: 95.5%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.25rem; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); outline: none; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; font-size: 1rem; min-height: 2.5rem;">{{ old('notes', $submittedData['notes'] ?? '') }}</textarea>
          </div>
          <button type="submit" style="width: 100%; padding: 0.75rem; background-color: #4c51bf; color: white; font-weight: 600; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border: none; cursor: pointer; transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
              SUBMIT
          </button>
        </form>
      </div>
    </div>
  </body>
</html>
