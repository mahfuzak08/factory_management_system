# Install the required library using pip:
# pip install pyzk
import requests
import json
from zk import ZK, const

# from pyzk.zkmodules import ZKModules
# from pyzk.zkmodules.defs import ZKFTDefinitions

def send_attendance_data(data):
    # Replace this with the URL of your web server endpoint for receiving attendance data
    # server_url = "https://rayan.absoft-bd.com/api/receive-data"
    server_url = "http://localhost:8000/api/receive-data"
    
    # Convert the attendance data to JSON format
    json_data = json.dumps(data)
    
    # Make a POST request to send attendance data to the web server
    response = requests.post(server_url, json=json_data)
    
    if response.status_code == 200:
        print("Attendance data sent successfully", response)
    else:
        print(f"Failed to send attendance data: {response.status_code}")
        
    return response.status_code
    # print("Response status code:", response.status_code)
    # print("Response headers:", response.headers)
    # print("Response content:", response.content)
    # print("Response text:", response.text)

def main():
    # Replace with the IP address and port of your ZKTeco K40 device
    device_ip = '192.168.0.201'
    device_port = 4370
    conn = None
        
    try:
        # create ZK instance
        zk = ZK(device_ip, device_port, timeout=5, password=0)
        # connect to device
        conn = zk.connect()
        print("ZK Attendance Device Connected Successfully")
        # Get attendance logs
        logs = zk.get_attendance()
        
        clear = 0
        # print("Returned value:", logs)  # Print the returned value
        print("Get Attendance Successfully")
        
        attendance_data = []
        # attendance_data = [{'uid': 20, 'user_id': '2', 'timestamp': '2024-05-23 11:59:28', 'status': 1, 'type': 0},{'uid': 21, 'user_id': '2', 'timestamp': '2024-05-23 23:59:28', 'status': 1, 'type': 0},{'uid': 22, 'user_id': '2', 'timestamp': '2024-05-24 00:01:28', 'status': 1, 'type': 0},{'uid': 23, 'user_id': '2', 'timestamp': '2024-05-24 09:02:28', 'status': 1, 'type': 0},{'uid': 24, 'user_id': '2', 'timestamp': '2024-05-24 12:01:28', 'status': 1, 'type': 0},{'uid': 25, 'user_id': '2', 'timestamp': '2024-05-25 09:02:28', 'status': 1, 'type': 0},{'uid': 26, 'user_id': '2', 'timestamp': '2024-05-25 20:40:28', 'status': 1, 'type': 0},{'uid': 27, 'user_id': '2', 'timestamp': '2024-05-26 10:40:28', 'status': 1, 'type': 0},{'uid': 28, 'user_id': '2', 'timestamp': '2024-05-26 21:40:28', 'status': 1, 'type': 0},{'uid': 29, 'user_id': '2', 'timestamp': '2024-05-27 09:00:28', 'status': 1, 'type': 0},{'uid': 30, 'user_id': '2', 'timestamp': '2024-05-27 21:00:28', 'status': 1, 'type': 0},{'uid': 31, 'user_id': '2', 'timestamp': '2024-05-28 14:00:28', 'status': 1, 'type': 0},{'uid': 32, 'user_id': '2', 'timestamp': '2024-05-28 21:00:28', 'status': 1, 'type': 0},{'uid': 33, 'user_id': '2', 'timestamp': '2024-05-29 08:40:28', 'status': 1, 'type': 0},{'uid': 34, 'user_id': '2', 'timestamp': '2024-05-29 14:30:28', 'status': 1, 'type': 0}]
        if logs:
            if isinstance(logs, list):
                for log in logs:
                    # print(log)
                    uid, user_id, timestamp, status, punch = log.uid, log.user_id, log.timestamp, log.status, log.punch
                    attendance_data.append({
                        'uid': uid,
                        'user_id': user_id,
                        'timestamp': timestamp.strftime('%Y-%m-%d %H:%M:%S'),
                        'status': status,
                        'type': punch
                    })
            else:
                # Handle the case where logs is not a list
                print(f"Unexpected return value: {logs}")
        else:
            print(f"No new data found")
            
        if attendance_data:
            clear = send_attendance_data(attendance_data)
            print(attendance_data)
            
    except Exception as e:
        print(f"Error: {e}")
    finally:
        if clear == 200:
            zk.clear_attendance()
        zk.disconnect()
        print(f"Done")

if __name__ == "__main__":
    main()
