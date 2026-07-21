<style>
	.stime-section{
		position:relative;
		width:100%;
		height:500px;
		overflow:hidden; /* NASCONDE quello che parte da sotto */
	}

	/* BACKGROUND separato per poterlo animare */
	.stime-bg{
		position:absolute;
		inset:0;
		background:no-repeat center;
		background-size:cover;
		transition: transform 1.2s ease;
	}

	/* BOX */
	.stime-box{
		position:absolute;
		width:470px;
		min-height:420px;
		background:var(--background);
		bottom:-420px;
		left:130px;
		transition: bottom 0.9s cubic-bezier(.22,.61,.36,1);
	}

	.stime-button{
		position:absolute;
		bottom:20px;
		right:20px;
	}

	/* Stato attivo */
	.stime-section.active .stime-box{
		bottom:40px;
	}

	.stime-section.active .stime-bg{
		transform: scale(1.05);
	}

	/* Contenuto */
	.stime-content{
		padding:20px 20px 72px;
		display:flex;
		flex-direction:column;
		gap:24px;
	}
	
	.stime-titolo{
		font-family:'Inria Serif';
		font-size:50px;
		font-style:italic;
		font-weight:300;
		line-height:45px;
	}

	.stime-testo{
		font-family:'Inria Sans';
		font-size:16px;
		font-weight:300;
		line-height:1.5;
		color:var(--blackLight);
	}

	@media (max-width: 700px) {
		.stime-box{
			width:80%;			
			left:50%;
			transform:translateX(-50%);

		}
		.stime-titolo{
			font-size:32px;
			line-height:30px;
		}
	}
</style>
<div class="stime-section">
    <div class="stime-bg" data-lazy-bg="{{ asset('images/stime_prezzi.png') }}"></div>

    <div class="stime-box">
        <div class="stime-content">
			<span class="stime-titolo">
				{{ __('home.stime-titolo') }}
			</span>
			<span class="stime-testo">
				{{ __('home.stime-testo') }}
			</span>
		</div>
		<div class="stime-button">
			<a href="{{ locale_route('certifications.estimates_coins') }}">
				<div class="morButton">
					<span class="morButtonTxt">{{ __('general.approfondisci') }}</span>
				</div>
			</a>
		</div>
    </div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function(){

		const section = document.querySelector(".stime-section");

		const observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
				if(entry.isIntersecting){
					setTimeout(() => {
						section.classList.add("active");
					}, 400);
				}
			});
		}, {
			threshold: 0.4
		});

		observer.observe(section);

	});
</script>
