<!DOCTYPE html>
<html>
<head>
    <title>Reminder Email</title>
</head>
<body>
    <h2>Upcoming {{ ucfirst($type) }} Reminder</h2>

    <p>Hello {{ $record->user->name }},</p>

    <p>This is a reminder that a {{ $type === 'medical' ? 'medical treatment' : 'vaccination' }} is scheduled for your livestock.</p>

    <p><strong>Date:</strong> {{ $record->date }}</p>
    @if($type === 'medical')
        <p><strong>Treatment:</strong> {{ $record->treatment }}</p>
    @else
        <p><strong>Vaccination:</strong> {{ $record->vaccination }}</p>
        <p><strong>Booster:</strong> {{ $record->booster ? 'Yes' : 'No' }}</p>
    @endif

    <p>Thank you for using LTMPS System!</p>
</body>
</html>
