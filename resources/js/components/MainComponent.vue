<template>
	<div>
		<div style="background: #eee; padding: 25px 0">
		    <div class="container">
		        <h1 class="display-3 text-center"><img src="https://www.medoucine.com/images/logos/logo.svg" width="350"/></h1>

		        <div class="mt-5 mb-2">
					<div class="form-row">
						<div class="col">
							<select class="form-control" id="city" @change="changeCity($event)">
								<option value="0">Choisir une ville</option>
								<option v-for="(data, key) in cities" :value="key">
							    	{{ key }}
							  	</option>
							</select>
						</div>
						<div class="col">
							<select class="form-control" id="practice" disabled>
								<option value="0">Choisir une spécialité</option>
								<option v-for="data in practices" :value="data">
							    	{{ data }}
							  	</option>
							</select>
						</div>
						<div class="col">
							<button type="button" class="btn btn-primary mb-2" style="width: 100%" v-on:click="submitForm()">Go !</button>
						</div>
					</div>
		        </div>
		    </div>
	    </div>

	    <div class="mt-3 mb-3">
		    <div class="container">
		    	<div class="row">
					<div class="col-6 d-none entry" v-for="therapist in therapists" v-bind:data-therapist="therapist.name" :data-city="therapist.city" :data-practices="therapist.practices">
						<div class="card mb-2">
							<div class="card-body">
								<div class="row">
									<div class="col-3"><img src="https://via.placeholder.com/120" /></div>
									<div class="col-9">
										<span class="card-title font-weight-bold">{{ therapist.name }}</span><br />
										<span>{{ therapist.city }}</span><br /><br />
										<span v-for="(practice, index) in therapist.practices">
											<span>{{practice}}</span><span v-if="index+1 < therapist.practices.length">, </span>
										</span>
									</div>
							  	</div>
							</div>
						</div>
		    		</div>
	    		</div>
    		</div>
    	</div>

	    <div class="mt-3 mb-3">
	    	<hr />
		    <div class="container">
		    	<div class="row">
					<div class="col" v-for="(data, key) in cities">
						<h4>{{ key }}</h4>

						<ul>
							<li v-for="practice in data"><a href="#" v-on:click="setSelect(key, practice)">{{ practice }}</a></li>
						</ul>
					</div>
				</div>
	    	</div>
    	</div>
    </div>
</template>

<script>
import json from '../.././../database/db.json'
export default {
    mounted() {
        var self = this // create a closure to access component in the callback below

        // on alimente les villes
	    $.getJSON('/api/cities', function(data) {
      		self.cities = data;
	    });

	    // on alimente les spécialités
	    $.getJSON('/api/practices', function(data) {
      		self.practices = data;
	    });

	    // on alimente les thérapistes
	    $.getJSON('/api/therapists', function(data) {
      		self.therapists = data;
	    });
    },
    data() {
      	return{
          	cities: [],
          	practices: [],
          	therapists: [],
      	}
  	},
    methods: {
    	// MAJ du select Spécialité en fonction du select Ville
    	changeCity(event) {
    		let selected = event.target.value;

    		$('#practice').prop('disabled', true);
            if(selected != 0) {
            	$('#practice').prop('disabled', false);
            }
        },
        // Simule l'envoi de formulaire via un link html
	    setSelect: function (city, practice) {
	    	$('#city').val(city);
	    	$('#practice').prop('disabled', false).val(practice);
	    	this.submitForm();
	    },
	    // Envoi du formulaire et affichage des cards correspondantes
	    submitForm: function() {
	    	let citySelected = $('#city').val();
	    	let practiceSelected = $('#practice').val();

	    	$('.entry').addClass('d-none');
	    	$('.entry').each(function(key, value) {
	    		let cityEntry = $(this).data('city');
	    		let practicesEntry = $(this).data('practices');

	    		if(citySelected == cityEntry && practicesEntry.indexOf(practiceSelected) != -1) {
	    			$(this).removeClass('d-none');
	    		}
	    	});
	    }
    }
}
</script>