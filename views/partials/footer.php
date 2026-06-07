
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            ClinicDesk System
        </div>
        <strong>Copyright &copy; 2026 <a href="#">ClinicDesk</a>.</strong> All rights reserved.
    </footer>
	<script>
function checkAndDownload(fileName) {
   
    const url = '/clinicdesk/uploads/prescriptions/' + fileName;
    
    fetch(url, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                window.open(url, '_blank');
            } else {
                
                alert('الملف غير موجود في الرابط التالي:\n' + url);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while connecting to the server.');
        });
}
</script>
</body>
</html>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>