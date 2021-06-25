<template>
	<div class="min-h-screen px-12 py-16">
		<div class="mb-10 text-3xl">
			<span>Today</span> /
			<span>This Week</span> /
			<span>Next Month</span>
		</div>

		<div v-for="single in upcoming" :key="single.id">
			<UpcomingSingle :upcoming="single"/>
		</div>

		<div class="relative mt-10 mb-4">
			<hr class="absolute top-3 z-10 w-full border-gray-400"/>
			<div class="uppercase font-bold absolute left-1/2 top-0 z-20 bg-white px-5">
				view all >>
			</div>
		</div>
	</div>
</template>

<script>
import UpcomingSingle from './UpcomingSingle';
export default {
	data() {
		const o = {
			name: 'Strategies for Engaging Crowds',
			category: 'Comedy',
			artist: 'Gordon',
			date: 'Today',
			time: '03:00PM GMT',
			avatar: 'images/rmd.jpg',
			description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic totam maxime modi iure reprehenderit qui quam architecto tenetur!",
			id: 1,
		};

		const a = [o, o, o];
		const b = a.map((v, i) => {
			const q = {};
			Object.assign(q, v);
			q.id += i;
			return q;
		});

		return {
			upcoming: b,
		}
	},
	components: {
		UpcomingSingle,
	}
}
</script>