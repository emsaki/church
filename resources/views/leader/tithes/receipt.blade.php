<h3>Tithe Receipt</h3>

<p><strong>Member:</strong> {{ $tithe->member->full_name }}</p>
<p><strong>Amount:</strong> {{ number_format($tithe->amount) }} TZS</p>
<p><strong>Date:</strong> {{ $tithe->tithe_date }}</p>
<p><strong>Recorded By:</strong> {{ $tithe->recorder->name }}</p>
