var groupName = document.getElementById('liuks_tablebundle_table_group_name').parentElement;
groupName.classList.add('hidden');

function groupToggle()
{
    if (document.getElementById('liuks_tablebundle_table_private').checked) {
        groupName.classList.remove('hidden');
    }
    else {
        groupName.classList.add('hidden');
    }
}