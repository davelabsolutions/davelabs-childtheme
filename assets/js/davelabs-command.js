(function () {
	var canvas = document.querySelector('[data-dl-network]');
	var nav = document.querySelector('.dl-nav');

	function updateNavState() {
		if (!nav) {
			return;
		}

		nav.classList.toggle('is-scrolled', window.scrollY > 28);
	}

	window.addEventListener('scroll', updateNavState, { passive: true });
	updateNavState();

	function initLoopCarousel(carousel, trackSelector, itemSelector, prevSelector, nextSelector) {
		var track = carousel.querySelector(trackSelector);
		var prev = carousel.querySelector(prevSelector);
		var next = carousel.querySelector(nextSelector);
		var startX = 0;
		var startOffset = 0;
		var offset = 0;
		var halfWidth = 0;
		var dragging = false;
		var pointerId = null;
		var resumeTimer = 0;

		function measure() {
			halfWidth = track ? track.scrollWidth / 2 : 0;
		}

		function normalize(value) {
			if (!halfWidth) {
				return value;
			}

			while (value > 0) {
				value -= halfWidth;
			}

			while (value <= -halfWidth) {
				value += halfWidth;
			}

			return value;
		}

		function getCurrentOffset() {
			var transform = window.getComputedStyle(track).transform;

			if (!transform || transform === 'none') {
				return offset;
			}

			var matrix = transform.match(/matrix.*\((.+)\)/);

			if (!matrix) {
				return offset;
			}

			var values = matrix[1].split(',').map(parseFloat);

			return values.length === 16 ? values[12] : values[4];
		}

		function render(value) {
			offset = normalize(value);
			carousel.style.setProperty('--dl-project-offset', offset + 'px');
		}

		function scheduleAutoResume() {
			window.clearTimeout(resumeTimer);
			resumeTimer = window.setTimeout(function () {
				carousel.classList.remove('is-manual');
			}, 4200);
		}

		function enableManualMode() {
			measure();
			offset = normalize(getCurrentOffset());
			carousel.classList.add('is-manual');
			render(offset);
		}

		function moveBy(direction) {
			var card = track.querySelector(itemSelector);
			var cardWidth = card ? card.getBoundingClientRect().width : 420;
			var gap = parseFloat(window.getComputedStyle(track).gap) || 18;

			enableManualMode();
			render(offset + direction * (cardWidth + gap));
			scheduleAutoResume();
		}

		function onPointerDown(event) {
			if (event.target.closest('.dl-project-arrow')) {
				return;
			}

			if (event.pointerType === 'mouse' && event.button !== 0) {
				return;
			}

			window.clearTimeout(resumeTimer);
			enableManualMode();
			dragging = true;
			pointerId = event.pointerId;
			startX = event.clientX;
			startOffset = offset;
			carousel.classList.add('is-dragging');
			carousel.setPointerCapture(pointerId);
		}

		function onPointerMove(event) {
			if (!dragging || event.pointerId !== pointerId) {
				return;
			}

			render(startOffset + event.clientX - startX);
		}

		function onPointerUp(event) {
			if (!dragging || event.pointerId !== pointerId) {
				return;
			}

			dragging = false;
			pointerId = null;
			carousel.classList.remove('is-dragging');
			scheduleAutoResume();
		}

		if (!track) {
			return;
		}

		measure();
		window.addEventListener('resize', measure, { passive: true });
		carousel.addEventListener('pointerdown', onPointerDown);
		carousel.addEventListener('pointermove', onPointerMove);
		carousel.addEventListener('pointerup', onPointerUp);
		carousel.addEventListener('pointercancel', onPointerUp);

		if (prev) {
			prev.addEventListener('pointerdown', function (event) {
				event.stopPropagation();
			});

			prev.addEventListener('click', function () {
				moveBy(1);
			});
		}

		if (next) {
			next.addEventListener('pointerdown', function (event) {
				event.stopPropagation();
			});

			next.addEventListener('click', function () {
				moveBy(-1);
			});
		}
	}

	document.querySelectorAll('[data-project-carousel]').forEach(function (carousel) {
		initLoopCarousel(carousel, '.dl-project-track', '.dl-project-card', '[data-project-prev]', '[data-project-next]');
	});

	document.querySelectorAll('[data-loop-carousel]').forEach(function (carousel) {
		initLoopCarousel(carousel, '.dl-property-track', '.dl-property-banner', '[data-loop-prev]', '[data-loop-next]');
	});

	if (!canvas) {
		return;
	}

	var ctx = canvas.getContext('2d');
	var points = [];
	var width = 0;
	var height = 0;
	var raf = 0;

	function resize() {
		var ratio = window.devicePixelRatio || 1;
		width = canvas.offsetWidth;
		height = canvas.offsetHeight;
		canvas.width = width * ratio;
		canvas.height = height * ratio;
		ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
		createPoints();
	}

	function createPoints() {
		var count = Math.max(52, Math.floor(width / 18));
		points = Array.from({ length: count }, function () {
			return {
				x: Math.random() * width,
				y: Math.random() * height,
				vx: (Math.random() - 0.5) * 0.18,
				vy: (Math.random() - 0.5) * 0.18,
				r: Math.random() * 1.45 + 0.55
			};
		});
	}

	function draw() {
		ctx.clearRect(0, 0, width, height);
		ctx.fillStyle = 'rgba(235, 242, 255, 0.78)';
		ctx.strokeStyle = 'rgba(75, 141, 227, 0.14)';
		ctx.lineWidth = 1;

		points.forEach(function (point, index) {
			point.x += point.vx;
			point.y += point.vy;

			if (point.x < 0 || point.x > width) {
				point.vx *= -1;
			}

			if (point.y < 0 || point.y > height) {
				point.vy *= -1;
			}

			ctx.beginPath();
			ctx.arc(point.x, point.y, point.r, 0, Math.PI * 2);
			ctx.fill();

			for (var next = index + 1; next < points.length; next += 1) {
				var other = points[next];
				var dx = point.x - other.x;
				var dy = point.y - other.y;
				var distance = Math.sqrt(dx * dx + dy * dy);

				if (distance < 118) {
					ctx.globalAlpha = (1 - distance / 118) * 0.7;
					ctx.beginPath();
					ctx.moveTo(point.x, point.y);
					ctx.lineTo(other.x, other.y);
					ctx.stroke();
					ctx.globalAlpha = 1;
				}
			}
		});

		raf = window.requestAnimationFrame(draw);
	}

	window.addEventListener('resize', resize);
	resize();
	draw();

	window.addEventListener('beforeunload', function () {
		window.cancelAnimationFrame(raf);
	});
}());
