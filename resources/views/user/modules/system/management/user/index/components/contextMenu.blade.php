<div class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-350px" id="contextMenu">
    <div class="menu-item px-3">
        <a onclick="userDetail()" class="menu-link px-3 my-3">
            <i class="fas fa-info-circle text-primary"></i><span class="ms-3">Detaylar</span>
        </a>
    </div>
    <div class="menu-item px-3">
        <a onclick="changeUserEmail()" class="menu-link px-3 my-3">
            <i class="fas fa-envelope-open text-info"></i><span class="ms-3">Mail Değiştir</span>
        </a>
    </div>
    <div class="menu-item px-3">
        <a onclick="deleteUser()" class="menu-link px-3 my-3">
            <i class="fas fa-trash text-danger"></i><span class="ms-3">Sil</span>
        </a>
    </div>
    <hr class="text-muted">
    <div class="menu-item px-3">
        <a onclick="downloadUsers()" class="menu-link px-3 my-3">
            <i class="fas fa-file-excel text-success"></i><span class="ms-3">Excel İndir</span>
        </a>
    </div>
</div>
