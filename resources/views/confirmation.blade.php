<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Confirmation</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body style="background-color: #f7fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;">
    <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px; text-align: center;">
        @if(session('status') == 'success')
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Submission Successful</h2>
            <p>Your breakage report has been submitted successfully.</p>
        @else
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; color: #2d3748;">Submission Failed</h2>
            <p>There was an error submitting your breakage report. Please try again.</p>
        @endif
        <form action="{{ session('status') == 'success' ? url('/lookup') : url()->previous() }}" method="get" style="margin-top: 1.5rem;">
            <button type="submit" style="padding: 0.75rem 1.5rem; background-color: #4c51bf; color: white; font-weight: 600; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); border: none; cursor: pointer; transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                OK
            </button>
        </form>
    </div>
</body>
</html>
