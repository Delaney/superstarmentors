<template>
	<div class="grid grid-cols-3 gap-3 items-center">
		<div>
			<img class="h-64 mx-auto" :src="upcoming.avatar" alt="">
		</div>
		<div>
			<div class="mb-3"><span class="font-bold">Artist</span>: {{upcoming.artist}}</div>
			<div class="mb-3"><span class="font-bold">Category</span>: {{upcoming.category}}</div>
			<div class="mb-3"><span class="font-bold">Topic</span>: {{upcoming.name}}</div>
			<div class="mb-3"><span class="font-bold">Date</span>: {{upcoming.date}}</div>
			<div class="mb-3"><span class="font-bold">Time</span>: {{upcoming.time}}</div>
		</div>
		<div>
			<div>
				<h5 class="text-xs font-bold uppercase">about the mentor</h5>
				<p class="mb-5">{{upcoming.description}}</p>
				<div class="uppercase mb-3 font-bold">
					read more >>
				</div>
				<button class="bg-transparent hover:bg-red-500 text-black font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded w-1/2">
					Attend
				</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		upcoming: {
			type: Object,
			required: true,
		}
	},
}
</script>