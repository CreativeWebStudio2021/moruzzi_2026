<style>
	.investimento-section{
		position:relative;
		width:100%;
		height:500px;
		overflow:hidden; /* NASCONDE quello che parte da sotto */
	}

	/* BACKGROUND separato per poterlo animare */
	.investimento-bg{
		position:absolute;
		inset:0;
		background:no-repeat center;
		background-size:cover;
		transition: transform 1.2s ease;
	}

	/* BOX */
	.investimento-box{
		position:absolute;
		width:700px;
		min-height:400px;
		background:var(--background);
		right:-500px;             
		top:40px;
		transition: right 0.9s cubic-bezier(.22,.61,.36,1);
	}

	.investimento-button{
		position:absolute;
		bottom:20px;
		right:30px;
	}

	/* Stato attivo */
	.investimento-section.active .investimento-box{
		right:130px;
	}

	.investimento-section.active .investimento-bg{
		transform: scale(1.05);
	}

	/* Contenuto */
	.investimento-content{
		padding:20px;
		display:flex;
		flex-direction:column;
		gap:0;
	}

	.investimento-titolo{
		font-family:'Inria Serif';
		font-size:50px;
		font-style:italic;
		font-weight:300;
		line-height:45px;
		margin-bottom:18px;
	}

	.investimento-sottotitolo{
		font-family:'Inria Serif';
		font-size:24px;
		font-style:italic;
		font-weight:300;
		line-height:28px;
		margin-bottom:26px;
	}

	.investimento-testo{
		font-family:'Inria Sans';
		font-size:16px;
		font-weight:300;
		line-height:1.55;
		color:var(--blackLight);
	}
	@media (max-width: 900px) {
		.investimento-box{
			width:86%;
		}
		.investimento-section.active .investimento-box{
			right:7%;
		}
	}
	@media (max-width: 700px) {
		.investimento-section{
			height:600px
		}
		.investimento-box{
			height:86%;
			top:7%;
		}

	}
	@media (max-width: 500px) {
		.investimento-section{
			height:700px
		}
		.investimento-sottotitolo{
			margin-bottom:10px;
		}
		.investimento-titolo{
			font-size:32px;
			line-height:30px;
		}

	}
</style>
<div class="investimento-section">
    <div class="investimento-bg" data-lazy-bg="{{ asset('images/investimento.png') }}"></div>

    <div class="investimento-box">
        <div class="investimento-content">
			<span class="investimento-titolo">
				{{ __('home.investimento-titolo') }}
			</span>
			<span class="investimento-sottotitolo">
				{{ __('home.investimento-sottotitolo') }}
			</span>
			<span class="investimento-testo">
				{{ __('home.investimento-testo') }}
			</span>
		</div>
		<div class="investimento-button">
            <a href="{{ locale_route('certifications.valuation') }}">
                <div class="morButton">
                    <span class="morButtonTxt">{{ __('general.approfondisci') }}</span>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function(){

		const section = document.querySelector(".investimento-section");

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
