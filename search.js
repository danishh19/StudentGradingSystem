// Search the student name, matric number, and subject columns.
const searchInput = document.getElementById('searchInput');
const searchForm = document.getElementById('search-form');
const rows = document.querySelectorAll('.result-row');

function filterRecords() {
    const query = searchInput.value.toLowerCase().trim();
    let visible = 0;

    for (const row of rows) {
        let matches = false;

        for (let column = 1; column <= 3; column++) {
            const text = row.cells[column].textContent.toLowerCase();
            if (text.includes(query)) {
                matches = true;
            }
        }

        row.hidden = !matches;
        if (matches) {
            visible++;
        }
    }

    let label = ' results';
    if (visible === 1) {
        label = ' result';
    }
    document.getElementById('record-count').textContent = visible + label;
    document.getElementById('empty-row').hidden = visible > 0;

    if (query !== '') {
        document.getElementById('empty-title').textContent = 'No matching results';
        document.getElementById('empty-description').textContent = 'Try another student, matric no. or subject.';
    } else {
        document.getElementById('empty-title').textContent = 'No results to display';
        document.getElementById('empty-description').textContent = 'Add a result to get started.';
    }
}

searchInput.addEventListener('input', filterRecords);
searchForm.addEventListener('submit', function (event) {
    event.preventDefault();
    filterRecords();
});
