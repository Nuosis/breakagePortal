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
      <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Breakage Data for Student ID: {{ request()->input('student_id') }}</h2>
          @if(isset($breakageData['response']['data']))
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem;">
                <thead>
                    <tr>
                        <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Type</th>
                        <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Equipment</th>
                        <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Cost</th>
                        <th style="border-bottom: 2px solid #cbd5e0; padding: 0.5rem; text-align: left;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($breakageData['response']['data'] as $breakage)
                        <tr>
                            <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['description'] }}</td>
                            <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['unitPrice'] }}</td>
                            <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['quantity'] }}</td>
                            <td style="border-bottom: 1px solid #e2e8f0; padding: 0.5rem;">{{ $breakage['fieldData']['price'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          @else
            <p>No breakage data found for this student ID.</p>
          @endif
      </div>
  </body>
</html>
