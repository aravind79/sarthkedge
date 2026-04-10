import paramiko
import os

from backup_manager import create_local_backup

def deploy():
    # Create local backup before deployment
    create_local_backup("landing_modernization")
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect('72.61.237.199', username='sarthakedge', password='Sarthakedge@2025')
    sftp = ssh.open_sftp()
    
    remote_root = '/home/sarthakedge/htdocs/sarthakedge.com/php_code_live/'
    local_root = r'e:\WORKS\sarthakedgenewcode-final'
    
    def put_file(rel_path):
        local = os.path.join(local_root, rel_path)
        remote = remote_root + rel_path.replace('\\', '/')
        print(f"Deploying {local} -> {remote}")
        sftp.put(local, remote)

    put_file(r'resources\views\home1.blade.php')
    put_file(r'resources\views\dashboard.blade.php')
    put_file(r'app\Http\Controllers\DashboardController.php')
    put_file(r'resources\views\landing-pages\pricing.blade.php')
    put_file(r'resources\views\layouts\home_page\footer.blade.php')
    put_file(r'resources\views\auth\login.blade.php')
    put_file(r'resources\views\landing-pages\about.blade.php')
    put_file(r'resources\views\landing-pages\contact.blade.php')
    put_file(r'app\Http\Controllers\Controller.php')
    put_file(r'routes\web.php')
    put_file(r'resources\views\layouts\home_page\header.blade.php')
    
    # Try images
    try:
        put_file(r'public\assets\web-site-images\teacher_app_v2.png')
        put_file(r'public\assets\web-site-images\student_dashboard_v2.png')
        put_file(r'public\assets\web-site-images\feat_student_v2.png')
        put_file(r'public\assets\web-site-images\feat_academics_v2.png')
        put_file(r'public\assets\web-site-images\feat_teacher_v2.png')
        put_file(r'public\assets\web-site-images\feat_session_v2.png')
        put_file(r'public\assets\web-site-images\feat_attendance_v2.png')
        put_file(r'public\assets\web-site-images\feat_fee_v2.png')
        put_file(r'public\assets\web-site-images\feat_communication_v2.png')
        put_file(r'public\assets\web-site-images\feat_exam_v2.png')
        put_file(r'public\assets\web-site-images\feat_homework_v2.png')
        put_file(r'public\assets\web-site-images\feat_transport_v2.png')
        put_file(r'public\assets\web-site-images\feat_reports_v2.png')
        put_file(r'public\assets\web-site-images\feat_access_v2.png')
        
        # New UI Screenshots
        put_file(r'public\assets\web-site-images\ui_login.jpg')
        put_file(r'public\assets\web-site-images\ui_dashboard.jpg')
        put_file(r'public\assets\web-site-images\ui_academics.jpg')
        put_file(r'public\assets\web-site-images\ui_chat.jpg')
        put_file(r'public\assets\web-site-images\ui_profile.jpg')
        put_file(r'public\assets\web-site-images\app_login.jpg')
        put_file(r'public\assets\web-site-images\app_academics.jpg')
        put_file(r'public\assets\web-site-images\app_chat.jpg')
        put_file(r'public\assets\web-site-images\app_dashboard.jpg')
        put_file(r'public\assets\web-site-images\app_profile.jpg')
    except Exception as e:
        print(f"Image deployment failed: {e}")
        
    sftp.close()
    
    # Cache clear
    print("Clearing caches...")
    ssh.exec_command(f'cd {remote_root} && php artisan view:clear && php artisan cache:clear')
    
    ssh.close()
    print("Deployment done!")

if __name__ == "__main__":
    deploy()
