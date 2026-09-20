/* ===== ДАННЫЕ (имитация БД) ===== */
const DATA = {
  works: [
    { title: "Открытка девушке №1", type: "course", tag: "Открытки", desc: "", link: "https://dofamean01-rgb.github.io/lovesonya/" },
    { title: "Интернет Магазин NextGen", type: "lab", tag: "Интернет-Магазин", desc: "Магазин ПК комплектующих", link: "https://dofamean01-rgb.github.io/NextGen/"  },
    { title: "Открытка девушке №2", type: "course", tag: "Открытки", desc: "", link: "https://dofamean01-rgb.github.io/love/" },
    
  ],
  skills: [
    { name: "HTML5 / CSS3", level: 85 },
    { name: "JavaScript", level: 75 },
    { name: "SQL / MySQL", level: 70 },
    { name: "Git", level: 65 },
    { name: "Figma", level: 60 }
  ],
  grades: [
    { subject: "Веб-программирование", term: "3 семестр", grade: 5 },
    { subject: "Базы данных", term: "4 семестр", grade: 4 },
    { subject: "Проектирование ИС", term: "4 семестр", grade: 5 },
    { subject: "Программирование на JS", term: "3 семестр", grade: 5 },
    { subject: "Информационные системы", term: "3 семестр", grade: 4 }
  ]
};

/* ===== РЕНДЕР РАБОТ ===== */
const worksGrid = document.getElementById('worksGrid');

function renderWorks(filter = 'all') {
  worksGrid.innerHTML = '';
  DATA.works
    .filter(w => filter === 'all' || w.type === filter)
    .forEach(w => {
      const el = document.createElement('article');
      el.className = 'work';
      el.innerHTML = `
        <span class="work__tag">${w.tag}</span>
        <h3 class="work__title">${w.title}</h3>
        <p class="work__desc">${w.desc}</p>
        <a class="work__link" href="${w.link}" target="_blank" rel="noopener noreferrer">
          Ссылка
        </a>
      `;
      worksGrid.appendChild(el);
    });
}

/* ===== ФИЛЬТР ===== */
document.querySelectorAll('.filter').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter').forEach(b => b.classList.remove('is-active'));
    btn.classList.add('is-active');
    renderWorks(btn.dataset.filter);
  });
});

/* ===== РЕНДЕР КОМПЕТЕНЦИЙ ===== */
const skillsList = document.getElementById('skillsList');

function renderSkills() {
  DATA.skills.forEach(s => {
    const el = document.createElement('div');
    el.className = 'skill';
    el.innerHTML = `
      <div class="skill__head"><span>${s.name}</span><span>${s.level}%</span></div>
      <div class="skill__bar"><div class="skill__fill" data-level="${s.level}"></div></div>
    `;
    skillsList.appendChild(el);
  });
}

/* ===== АНИМАЦИЯ ПОЛОСОК ===== */
function animateSkills() {
  document.querySelectorAll('.skill__fill').forEach(fill => {
    const level = fill.dataset.level;
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          fill.style.width = level + '%';
          io.disconnect();
        }
      });
    }, { threshold: 0.4 });
    io.observe(fill);
  });
}

/* ===== РЕНДЕР ОЦЕНОК ===== */
const gradesBody = document.querySelector('#gradesTable tbody');

function renderGrades() {
  DATA.grades.forEach(g => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${g.subject}</td>
      <td>${g.term}</td>
      <td><span class="badge badge--${g.grade}">${g.grade}</span></td>
    `;
    gradesBody.appendChild(tr);
  });
}

/* ===== СТАТИСТИКА В ГЕРОЕ ===== */
function renderStats() {
  document.getElementById('statWorks').textContent = DATA.works.length;
  document.getElementById('statSkills').textContent = DATA.skills.length;
  document.getElementById('statGrades').textContent = DATA.grades.length;
}

/* ===== ЭКСПОРТ В PDF ===== */
function exportPDF() {
  window.print();
}
document.getElementById('exportBtn').addEventListener('click', exportPDF);
document.getElementById('exportTop').addEventListener('click', exportPDF);

/* ===== БУРГЕР-МЕНЮ ===== */
const burger = document.getElementById('burger');
const nav = document.getElementById('nav');
burger.addEventListener('click', () => nav.classList.toggle('is-open'));
nav.querySelectorAll('.nav__link').forEach(link => {
  link.addEventListener('click', () => nav.classList.remove('is-open'));
});

/* ===== ОТПРАВКА ФОРМЫ ЗАЯВКИ ===== */
const form = document.getElementById('contactForm');

if (form) {
  const statusEl = document.getElementById('formStatus');
  const submitBtn = document.getElementById('submitBtn');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Очищаем прошлый статус
    statusEl.textContent = '';
    statusEl.className = 'form__status';

    // Собираем данные
    const formData = new FormData(form);

    // Блокируем кнопку на время отправки
    submitBtn.disabled = true;
    submitBtn.textContent = 'Отправка...';

    try {
      const response = await fetch('send.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        statusEl.textContent = 'Спасибо! Заявка отправлена.';
        statusEl.classList.add('form__status--ok');
        form.reset();
      } else {
        statusEl.textContent = result.error || 'Что-то пошло не так.';
        statusEl.classList.add('form__status--error');
      }
    } catch (err) {
      statusEl.textContent = 'Ошибка сети. Попробуйте позже.';
      statusEl.classList.add('form__status--error');
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Отправить';
    }
  });
}

/* ===== ИНИЦИАЛИЗАЦИЯ ===== */
renderWorks();
renderSkills();
renderGrades();
renderStats();
animateSkills();