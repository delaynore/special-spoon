document.addEventListener("DOMContentLoaded", function () {
    const treeview = document.querySelector('.treeview');

    function toggleNode(event) {
        const li = event.target.closest('li');
        const ul = li.querySelector('ul');
        if (ul) {
            ul.classList.toggle('hidden');
            const isOpen = !ul.classList.contains('hidden');
            const icon = li.querySelector('.tree-view-icon');
            const block = li.querySelector('div');
            if(isOpen) {
                icon.style.transform = 'rotate(-90deg)';
                block.classList.add('active');
            }
            else {
                icon.style.transform = '';
                block.classList.remove('active');
            }

            const nodeId = li.getAttribute('data-id');
            console.log(nodeId);
            sessionStorage.setItem(nodeId, isOpen);
            console.log(sessionStorage.key('concept-'));
        }
    }

    treeview.querySelectorAll('.toggle').forEach(toggle => {
        toggle.addEventListener('click', toggleNode);
    });

    treeview.querySelectorAll('li[data-id]').forEach(li => {
        const nodeId = li.getAttribute('data-id');
        const isOpen = sessionStorage.getItem(nodeId) === 'true';
        const ul = li.querySelector('ul');
        if (ul && isOpen) {
            ul.classList.remove('hidden');
            console.log(nodeId);
            li.querySelector('.tree-view-icon').style.transform = 'rotate(-90deg)';
            li.querySelector('div').classList.add('active');
        }
    });

});

window.addEventListener("load", function () {
    const treeview = document.querySelector('.treeview');
    treeview.querySelectorAll('div.open-concept').forEach(div => {
        div.addEventListener('dblclick', (e) => {
            const route = e.currentTarget.dataset.openConceptRoute;
            console.log('click', e.currentTarget.dataset);
            window.location.href = route;
        });
    })
});
