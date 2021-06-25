<template>
	<div class="h-full">
		<div class="grid grid-cols-3 gap-4 py-20 px-24 sm:px-16">
			<div>
				<h3 class="text-5xl sm:text-4xl">Popular Mentors<br />(Voted By You)</h3>
			</div>
			
			<div v-for="mentor in mentors" :key="mentor.id" class="px-12 sm:px-4">
				<img :src="mentor.avatar" :alt="mentor.name" class="border-gray-600 mb-8">
				<div class="text-center">
					<h6>{{mentor.name}}</h6>
					<div class="text-lg" role="button">+ Follow</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		const o = {
			name: 'Richard Mofe-Damijo',
			avatar: 'images/rmd.jpg',
			id: 1,
		};

		const a = [o, o, o, o, o];
		const b = a.map((v, i) => {
			const q = {};
			Object.assign(q, v);
			q.id += i;
			return q;
		});

		return {
			mentors: b,
		}
	}
}
</script>