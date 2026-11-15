document.addEventListener('DOMContentLoaded', () => {
  const addButton = document.getElementById('addSubject');
  const rows = document.getElementById('subjectRows');
  if (addButton && rows) addButton.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'subject-row';
    row.innerHTML = '<input name="subject_name[]" placeholder="Subject name" required><input type="number" name="target_hours[]" min="0.25" max="24" step="0.25" value="2" required aria-label="Daily target hours"><span>hrs/day</span><button type="button" class="remove-row" aria-label="Remove subject">×</button>';
    row.querySelector('.remove-row').addEventListener('click', () => row.remove());
    rows.appendChild(row);
  });

  const dataNode = document.getElementById('chartData');
  const canvas = document.getElementById('studyChart');
  if (dataNode && canvas && window.Chart) {
    const data = JSON.parse(dataNode.textContent);
    new Chart(canvas, {
      type: 'line',
      data,
      options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, padding: 22, font: { family: 'Inter', size: 12, weight: '600' } } },
          tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} hours` } }
        },
        scales: {
          x: { title: { display: true, text: 'Day of month' }, grid: { display: false } },
          y: { beginAtZero: true, title: { display: true, text: 'Study hours' }, ticks: { precision: 1 } }
        }
      }
    });
  }
  const download = document.getElementById('downloadChart');
  if (download && canvas) download.addEventListener('click', () => {
    const link = document.createElement('a');
    link.download = `SL-AL-study-chart-${new URLSearchParams(location.search).get('month') || new Date().toISOString().slice(0,7)}.png`;
    link.href = canvas.toDataURL('image/png'); link.click();
  });
});
