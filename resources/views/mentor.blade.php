<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SuperStar Mentors</title>

	<link rel="stylesheet" href="{{ mix('css/mentor.css') }}"></link>

</head>
<body>
	<div id="app">
		<App>
			<router-view></router-view>
		</App>
	</div>
	
	<script src="{{ mix('js/mentor.js') }}"></script>
</body>
</html>