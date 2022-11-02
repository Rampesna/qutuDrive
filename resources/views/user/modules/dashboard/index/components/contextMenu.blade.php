<div class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-350px" id="contextMenu">
    <div class="menu-item px-3">
        <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">İşlemler</div>
    </div>
    <div class="separator mb-3 opacity-75"></div>
    <div id="uploadFileTransactionDiv">
        <div class="menu-item px-3">
            <a onclick="uploadFileTransaction()" class="menu-link px-3">
                <i class="fas fa-file text-dark"></i><span class="ms-4">Dosya Yükle</span>
            </a>
        </div>
    </div>
    <div id="createDirectoryTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="createDirectoryTransaction()" class="menu-link px-3">
                <i class="fas fa-folder-open text-dark"></i><span class="ms-4">Klasör Oluştur</span>
            </a>
        </div>
    </div>
    <div class="separator mb-3 opacity-75"></div>
    <div id="downloadTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="downloadTransaction()" class="menu-link px-3">
                <i class="fas fa-download text-dark"></i><span class="ms-4">İndir</span>
            </a>
        </div>
    </div>
    <div id="cutTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="cutTransaction()" class="menu-link px-3">
                <i class="fas fa-cut text-dark"></i><span class="ms-4">Kes</span>
            </a>
        </div>
    </div>
    <div id="copyTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="copyTransaction()" class="menu-link px-3">
                <i class="fas fa-copy text-dark"></i><span class="ms-4">Kopyala</span>
            </a>
        </div>
    </div>
    <div id="pasteTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="pasteTransaction()" class="menu-link px-3">
                <i class="fas fa-paste text-dark"></i><span class="ms-4">Yapıştır</span>
            </a>
        </div>
    </div>
    <div id="renameTransactionDiv">
        <div class="menu-item mb-3 px-3">
            <a onclick="renameTransaction()" class="menu-link px-3">
                <i class="fas fa-edit text-dark"></i><span class="ms-4">Yeniden Adlandır</span>
            </a>
        </div>
    </div>
    <div id="deleteTransactionDiv">
        <div class="separator mb-3 opacity-75"></div>
        <div class="menu-item mb-3 px-3">
            <a onclick="deleteTransaction()" class="menu-link px-3">
                <i class="fas fa-trash-alt text-danger"></i><span class="ms-4">Sil</span>
            </a>
        </div>
    </div>
    <div id="propertiesTransactionDiv">
        <div class="separator mb-3 opacity-75"></div>
        <div class="menu-item mb-3 px-3">
            <a onclick="propertiesTransaction()" class="menu-link px-3">
                <i class="fas fa-list text-dark"></i><span class="ms-4">Özellikler</span>
            </a>
        </div>
    </div>
</div>
