<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Nomor Perkara') }}</th>
      <th class="text-center">{{ __('File Penetapan') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nomor_perkara }}</td>
        <td>{{ $item->file_penetapan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
