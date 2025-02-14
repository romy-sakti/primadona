<table>
  <thead>
    <tr>
      <th>{{ __('#') }}</th>
      <th class="text-center">{{ __('Nama jenis') }}</th>
      <th class="text-center">{{ __('Deskripsi') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_jenis }}</td>
        <td>{{ $item->deskripsi }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
