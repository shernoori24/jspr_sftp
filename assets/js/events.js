function editEvent(id, title, description, date, image) {
  document.getElementById('eventId').value = id;
  document.getElementById('title').value = title;
  document.getElementById('description').value = description;
  document.getElementById('date').value = date.replace(' ', 'T');
  document.getElementById('image').value = image; }