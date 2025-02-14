<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('permohonan_masyarakat') }}</title>

  <link rel="stylesheet" href="{{ asset('assets/css/export-pdf.min.css') }}">
</head>

<body>
  <h1>{{ __('permohonan_masyarakat') }}</h1>
  <h3>{{ __('Total Data:') }} {{ $data->count() }}</h3>
  <table>
    <thead>
      <tr>
        <th>{{ __('#') }}</th>
        <th class="text-center">{{ __('Nama Pemohon') }}</th>
        <th class="text-center">{{ __('Jenis Permohonan') }}</th>
        <th class="text-center">{{ __('Nomor Perkara') }}</th>
        <th class="text-center">{{ __('Status Permohonan') }}</th>
        <th class="text-center">{{ __('Keterangan') }}</th>
        <th class="text-center">{{ __('Dokumen Penetapan') }}</th>
        <th class="text-center">{{ __('Nomor Telp') }}</th>
        <th class="text-center">{{ __('Alamat') }}</th>
        <th class="text-center">{{ __('Tempat Lahir') }}</th>
        <th class="text-center">{{ __('Tanggal lahir') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->nama_pemohon }}</td>
          <td>{{ $item->jenis_permohonan_id }}</td>
          <td>{{ $item->nomor_perkara }}</td>
          <td>{{ $item->status_permohonan }}</td>
          <td>{{ $item->keterangan }}</td>
          <td>{{ $item->dokumen_penetapan }}</td>
          <td>{{ $item->nomor_telepon }}</td>
          <td>{{ $item->alamat_pemohon }}</td>
          <td>{{ $item->tempat_lahir }}</td>
          <td>{{ $item->tanggal_lahir }}</td>
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
