// Functions for the Group 1 Team Profile page
// Exercise 2: live search
const cards = document.querySelectorAll('.card');
document.getElementById('searchBox').addEventListener('input', function () {
  const q = this.value.toLowerCase().trim();
  let found = false;
  cards.forEach(c => {
    const match = c.dataset.name.includes(q);
    c.style.display = match ? '' : 'none';
    if (match) found = true;
  });
  document.getElementById('noResult').style.display = (!found && cards.length) ? 'block' : 'none';
});

// Exercise 2: View Profile pop-up
const modal = document.getElementById('profileModal');
document.querySelectorAll('.view-btn').forEach(b => b.addEventListener('click', () => {
  document.getElementById('modalName').textContent = b.dataset.name;
  document.getElementById('modalRole').textContent = b.dataset.role;
  document.getElementById('modalCourse').textContent = b.dataset.course;
  document.getElementById('modalAge').textContent = b.dataset.age;
  document.getElementById('modalImage').src = b.dataset.image;
  modal.classList.add('open');
  document.getElementById('closeBtn').focus();
}));
const closeModal = () => modal.classList.remove('open');
document.getElementById('closeBtn').addEventListener('click', closeModal);
modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
