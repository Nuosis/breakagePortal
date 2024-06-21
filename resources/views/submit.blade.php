<!-- resources/views/submit.blade.php -->
<form action="/submit" method="post">
  @csrf
  <label for="student_id">Student ID:</label>
  <input type="text" id="student_id" name="student_id">
  <label for="fa">FA#:</label>
  <input type="text" id="fa" name="fa">
  <label for="school">School:</label>
  <select id="school" name="school">
      <!-- Options -->
  </select>
  <label for="damage_type">Type of damage:</label>
  <select id="damage_type" name="damage_type">
      <option value="accident">Accident</option>
      <option value="intentional">Intentional</option>
      <option value="lost">Lost/Stolen</option>
  </select>
  <label for="equipment">Equipment Damaged:</label>
  <select id="equipment" name="equipment">
      <option value="ipad">iPad</option>
      <option value="case">Case</option>
      <option value="ipad_keyboard">iPad + Keyboard</option>
  </select>
  <label for="notes">Notes:</label>
  <textarea id="notes" name="notes"></textarea>
  <button type="submit">SUBMIT</button>
</form>
