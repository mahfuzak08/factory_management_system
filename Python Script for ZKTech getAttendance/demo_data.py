import random
import datetime

# Function to generate random timestamps for a given date and user
def generate_timestamps(date, user_id, num_timestamps):
    timestamps = []
    prev_timestamp = None
    for _ in range(num_timestamps):
        hour = random.randint(8, 17)  # Random hour between 8 AM and 5 PM
        minute = random.randint(0, 59)
        second = random.randint(0, 59)
        timestamp = datetime.datetime(date.year, date.month, date.day, hour, minute, second)
        if prev_timestamp is not None and timestamp <= prev_timestamp:
            timestamp = prev_timestamp + datetime.timedelta(seconds=random.randint(1, 3600))  # Add 1-3600 seconds to ensure uniqueness
        prev_timestamp = timestamp
        timestamps.append({'uid': len(timestamps) + 1, 'user_id': user_id, 'timestamp': timestamp.strftime("%Y-%m-%d %H:%M:%S"), 'status': 1, 'type': 0})
    return timestamps

# Function to generate attendance data for a user for a full month
def generate_month_attendance(user_id):
    start_date = datetime.date(2024, 5, 1)
    end_date = datetime.date(2024, 5, 31)
    attendance_data = []
    for single_date in [start_date + datetime.timedelta(days=n) for n in range((end_date - start_date).days + 1)]:
        timestamps = generate_timestamps(single_date, user_id, random.randint(2, 5))  # Generate 2 to 5 timestamps per day
        attendance_data.extend(timestamps)
    return attendance_data

# Generate attendance data for two users
user1_data = generate_month_attendance('1')
# user2_data = generate_month_attendance('2')

# Print the generated attendance data
print(user1_data)
# print(user2_data)