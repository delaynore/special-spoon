const TreeView = (() => {
    const treeview = document.querySelector('.treeview');

    const toggleNode = (event) => {
        const li = event.target.closest('li');
        const ul = li.querySelector('ul');
        if (ul) {
            const isOpen = toggleElementVisibility(ul);
            updateNodeAppearance(li, isOpen);
            saveNodeState(li, isOpen);
        }
    };

    const hideNode = (toggle, isOpen) => {
        const li = toggle.closest('li');
        const ul = li.querySelector('ul');
        if (ul) {
            toggleElementVisibility(ul, isOpen);
            updateNodeAppearance(li, isOpen);
            saveNodeState(li, isOpen);
        }
    };

    const toggleElementVisibility = (element, isOpen = null) => {
        if (isOpen !== null) {
            element.classList.toggle('hidden', !isOpen);
        } else {
            element.classList.toggle('hidden');
        }
        return !element.classList.contains('hidden');
    };

    const updateNodeAppearance = (li, isOpen) => {
        const icon = li.querySelector('.tree-view-icon');
        const block = li.querySelector('div');
        icon.style.transform = isOpen ? 'rotate(-90deg)' : '';
        block.classList.toggle('active', isOpen);
    };

    const saveNodeState = (li, isOpen) => {
        const nodeId = li.getAttribute('data-id');
        sessionStorage.setItem(nodeId, isOpen);
    };

    const initialize = () => {
        const togglers = treeview.querySelectorAll('.toggler');
        togglers.forEach(toggle => {
            toggle.addEventListener('click', toggleNode);
        });

        let isOpenG = true;
        document.getElementById('collapse-concepts').addEventListener('click', () => {
            isOpenG = !isOpenG;
            togglers.forEach(toggle => {
                hideNode(toggle, isOpenG);
            });
        });

        treeview.querySelectorAll('li[data-id]').forEach(li => {
            const nodeId = li.getAttribute('data-id');
            const isOpen = sessionStorage.getItem(nodeId) === 'true';
            const ul = li.querySelector('ul');
            if (ul && isOpen) {
                ul.classList.remove('hidden');
                li.querySelector('.tree-view-icon').style.transform = 'rotate(-90deg)';
                li.querySelector('div').classList.add('active');
            }
        });
    };

    return {
        initialize
    };
})();

const ContextMenu = (() => {
    const contextmenu = document.getElementById('contextmenu');
    const treeview = document.querySelector('.treeview');
    let opened = false;
    const handleContextMenu = (event, concept) => {
        if (opened) {
            contextmenu.classList.add('hidden');
            opened = false;
        }

        event.preventDefault();
        event.stopPropagation();

        const title = contextmenu.querySelector('#contextmenu-title');
        const openConcept = contextmenu.querySelector('#contextmenu-open');
        if(concept.owner === 'true') {
            const createParent = contextmenu.querySelector('#contextmenu-create-parent');
            const createBrother = contextmenu.querySelector('#contextmenu-create-brother');
            const editConcept = contextmenu.querySelector('#contextmenu-edit');
            const deleteConcept = contextmenu.querySelector('#contextmenu-delete');
            createParent.href = concept.parent;
            createBrother.href = concept.brother;
            editConcept.href = concept.edit;
            deleteConcept.action = concept.delete;
        }
        title.textContent = concept.name;
        openConcept.action = concept.open;

        const x = event.pageX;
        const y = event.pageY;
        const menuWidth = contextmenu.offsetWidth;

        contextmenu.style.left = x + menuWidth + 'px';
        contextmenu.style.top = y + 'px';
        contextmenu.style.right = 'auto';
        contextmenu.classList.toggle('hidden');
        opened = true;
    };

    const initialize = () => {
        treeview.querySelectorAll('div.open-concept').forEach(div => {
            div.addEventListener('click', (e) => {
                const route = e.currentTarget.dataset.openConceptRoute;
                window.location.href = route;
            });
        });

        treeview.querySelectorAll('li[data-el="concept"]').forEach(li => {
            const concept = {
                name: li.dataset.name,
                parent: li.dataset.createParent,
                brother: li.dataset.createBrother,
                edit: li.dataset.edit,
                delete: li.dataset.delete,
                open: li.dataset.open,
                owner: li.dataset.owner
            };
            const div = li.querySelector('.lidiv');
            div.addEventListener('contextmenu', (event) => handleContextMenu(event, concept));
        });

        document.addEventListener('click', (event) => {
            if (!contextmenu.contains(event.target))
                contextmenu.classList.add('hidden');
        });
        document.addEventListener('contextmenu', (event) => {
            if (!contextmenu.contains(event.target))
                contextmenu.classList.add('hidden');
        });
    };

    return {
        initialize
    };
})();

// Инициализация модулей
document.addEventListener("DOMContentLoaded", () => {
    TreeView.initialize();
    ContextMenu.initialize();
});
