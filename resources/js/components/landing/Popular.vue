<template>
	<div class="h-full">
		<div class="grid grid-cols-3 gap-8 py-4 px-8">
			<div>
				<h3>Popular Mentors<br />(Voted By You)</h3>
			</div>
			
			<div v-for="mentor in mentors" :key="mentor.id">
				<img :src="mentor.avatar" :alt="mentor.name" class="p-5 border-gray-600">
				<h6>{{mentor.name}}</h6>
				<div class="" role="button">+ Follow</div>
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