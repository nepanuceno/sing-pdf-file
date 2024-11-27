const fileInput = document.getElementById('file-input');
const form = document.getElementById('pdf-form');
const fileList = document.getElementById('file-list');
const fileListDownload = document.getElementById('file-list-download');
const uploadBtn = document.getElementById('upload-btn');
const progressContainer = document.getElementById('progress-container');
const progressBar = document.getElementById('progress-bar');
const linkBlob = document.getElementById('blob');

const selectedFiles = new Set();

fileInput.addEventListener('change', function() {
    Array.from(this.files).forEach(file => {
        if (file.type === 'application/pdf' && !selectedFiles.has(file)) {
            selectedFiles.add(file);
            renderFileList();
        }
    });
});

function renderFileList() {
    fileList.innerHTML = '';
    selectedFiles.forEach(file => {
        const fileItem = document.createElement('div');
        fileItem.classList.add('file-item');
        
        const fileName = document.createElement('span');
        fileName.classList.add('file-name');
        fileName.textContent = file.name;

        const removeBtn = document.createElement('span');
        removeBtn.classList.add('remove-file');
        removeBtn.textContent = '✖';
        removeBtn.addEventListener('click', () => {
            selectedFiles.delete(file);
            renderFileList();
        });

        fileItem.appendChild(fileName);
        fileItem.appendChild(removeBtn);
        fileList.appendChild(fileItem);
    });

    uploadBtn.disabled = selectedFiles.size === 0;
}

function renderListaFilesDownload(files) {
    let resp = JSON.parse(files);
    fileListDownload.innerHTML = '';

    console.log(resp.zipFile);

    
    console.log(`Name: ${resp.zipFile}`);
    const fileItem = document.createElement('div');
    fileItem.classList.add('file-item');
    
    const fileName = document.createElement('span');
    fileName.classList.add('file-name');
    fileName.textContent = resp.zipFile;

    const downloadBtn = document.createElement('a');
    downloadBtn.classList.add('download-file');
    downloadBtn.textContent = 'Baixar';
    downloadBtn.href = "./Storage/" + resp.zipFile;
    downloadBtn.addEventListener('click', () => {
        selectedFiles.delete(resp.zipFile);
        renderFileList();
    });

    fileItem.appendChild(fileName);
    fileItem.appendChild(downloadBtn);
    fileListDownload.style.display = 'block';
    fileListDownload.appendChild(fileItem);
    
}

function getFileName(xhr) {
    const contentDisposition = xhr.getResponseHeader('Content-Disposition');
    if (contentDisposition) {
        const matches = /filename="([^"]*)"/.exec(contentDisposition);
        if (matches != null && matches[1]) { 
            filename = matches[1];
        }
        return filename;
    }
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(form);
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.responseType = "blob";

    progressContainer.style.display = 'block';
    uploadBtn.disabled = true;

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = `${percentComplete}%`;
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200 || hr.status === 201) {
            const blob = xhr.response;
            filename = getFileName(xhr);

            // You can now use the Blob object, for example, to create a URL and download the file
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename; // Replace with your desired file name and extension
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            //renderListaFilesDownload(xhr.response);
            selectedFiles.clear();
            fileInput.value = '';
            renderFileList();
        } else {
            alert('Erro ao Assinar');
        }
        progressContainer.style.display = 'none';
        progressBar.style.width = '0%';
        uploadBtn.disabled = false;
    };

    xhr.send(formData);
});
