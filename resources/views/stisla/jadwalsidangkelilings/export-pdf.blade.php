<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('jadwal_sidang_keliling') }}</title>

  <link rel="stylesheet" href="{{ asset('assets/css/export-pdf.min.css') }}">
</head>

<body>
  <h1>{{ __('jadwal_sidang_keliling') }}</h1>
  <h3>{{ __('Total Data:') }} {{ $data->count() }}</h3>
  <table>
    <thead>
      <tr>
        <th>{{ __('#') }}</th>
        <th class="text-center">{{ __('Tanggal Sidang') }}</th>
        <th class="text-center">{{ __('Nama Pemohon') }}</th>
        <th class="text-center">{{ __('Tempat Sidang') }}</th>
        <th class="text-center">{{ __('Agenda Sidang') }}</th>
        <th class="text-center">{{ __('Hakim') }}</th>
        <th class="text-center">{{ __('Panitera Penggati') }}</th>
        <th class="text-center">{{ __('Nomor Perkara') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->tanggal_sidang }}</td>
          <td>{{ $item->nama_pemohon }}</td>
          <td>{{ $item->tempat_sidang }}</td>
          <td>{{ $item->agenda_sidang }}</td>
          <td>{{ $item->hakim }}</td>
          <td>{{ $item->panitera_pengganti }}</td>
          <td>{{ $item->nomor_perkara }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if (($isPrint ?? false) === true)
    <script>
      window.print();
    </script>
  @endif

</body>

</html>
