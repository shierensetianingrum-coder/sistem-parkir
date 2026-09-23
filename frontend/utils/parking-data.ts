export const petugasMenu = [
  { key: 'dashboard', label: 'Dashboard', icon: 'home' },
  { key: 'member', label: 'Kelola member', icon: 'users' },
  { key: 'scan_masuk', label: 'Scan masuk', icon: 'car' },
  { key: 'scan_keluar', label: 'Scan keluar', icon: 'gate' },
  { key: 'ticket', label: 'Tiket', icon: 'ticket' },
  { key: 'laporan', label: 'Laporan', icon: 'chart' },
]

export const kpis = [
  { label: 'Member terdaftar', value: '128', tag: 'Total', icon: 'users', iconBg: 'bg-indigo-50', iconColor: 'text-indigo-600' },
  { label: 'Kendaraan masuk', value: '86', tag: 'Hari ini', icon: 'car', iconBg: 'bg-emerald-50', iconColor: 'text-emerald-600' },
  { label: 'Pendapatan', value: 'Rp 258.000', tag: 'Hari ini', icon: 'chart', iconBg: 'bg-amber-50', iconColor: 'text-amber-600' },
  { label: 'Sedang parkir', value: '42', tag: 'Live', icon: 'gate', iconBg: 'bg-rose-50', iconColor: 'text-rose-600' },
]

export const quickActions = [
  { key: 'member', icon: 'users', title: 'Kelola member', desc: 'Data & pembayaran member' },
  { key: 'scan_masuk', icon: 'car', title: 'Scan masuk', desc: 'Kendaraan masuk area parkir' },
  { key: 'scan_keluar', icon: 'gate', title: 'Scan keluar', desc: 'Proses kendaraan keluar' },
]

export const recentActivity = [
  { plate: 'B 1234 XYZ', type: 'masuk', time: '2 menit lalu' },
  { plate: 'B 5678 ABC', type: 'keluar', time: '10 menit lalu' },
  { plate: 'B 9012 DEF', type: 'masuk', time: '23 menit lalu' },
]

export const members = [
  { name: 'Andi Saputra', plate: 'B 1234 XYZ', type: 'Bulanan', expiry: '30 Sep 2026', status: 'Aktif' },
  { name: 'Siti Rahma', plate: 'B 5678 ABC', type: 'Tahunan', expiry: '15 Jan 2027', status: 'Aktif' },
  { name: 'Budi Hartono', plate: 'B 9012 DEF', type: 'Bulanan', expiry: '10 Sep 2026', status: 'Akan berakhir' },
  { name: 'Dewi Lestari', plate: 'B 3344 GHI', type: 'Bulanan', expiry: '28 Agu 2026', status: 'Nonaktif' },
  { name: 'Rian Pratama', plate: 'B 7788 JKL', type: 'Tahunan', expiry: '5 Des 2026', status: 'Aktif' },
  { name: 'Maya Anggraini', plate: 'B 2211 MNO', type: 'Bulanan', expiry: '25 Sep 2026', status: 'Akan berakhir' },
  { name: 'Fajar Nugroho', plate: 'B 6655 PQR', type: 'Bulanan', expiry: '2 Okt 2026', status: 'Aktif' },
  { name: 'Nadia Kusuma', plate: 'B 4433 STU', type: 'Tahunan', expiry: '19 Mar 2027', status: 'Aktif' },
]

export const activeTickets = [
  { id: 'TKT-0231', plate: 'B 1234 XYZ', vehicle: 'Mobil', time: '07:42', estimate: 'Rp 8.000' },
  { id: 'TKT-0230', plate: 'B 8890 QWE', vehicle: 'Motor', time: '07:38', estimate: 'Rp 2.000' },
  { id: 'TKT-0229', plate: 'B 4410 LMN', vehicle: 'Mobil', time: '07:15', estimate: 'Rp 10.000' },
  { id: 'TKT-0228', plate: 'B 7723 UIO', vehicle: 'Mobil', time: '06:50', estimate: 'Rp 12.000' },
]

export const hourlyIncome = [
  { hour: '06', pct: 30 }, { hour: '07', pct: 55 }, { hour: '08', pct: 90 },
  { hour: '09', pct: 70 }, { hour: '10', pct: 45 }, { hour: '11', pct: 60 }, { hour: '12', pct: 80 },
]

export const transactionsToday = [
  { time: '07:42', plate: 'B 1234 XYZ', vehicle: 'Mobil', fare: 'Rp 8.000' },
  { time: '07:40', plate: 'B 5678 ABC', vehicle: 'Mobil', fare: 'Rp 10.000' },
  { time: '07:33', plate: 'B 1122 ZXC', vehicle: 'Motor', fare: 'Rp 3.000' },
  { time: '07:15', plate: 'B 4410 LMN', vehicle: 'Mobil', fare: 'Rp 6.000' },
]

export const adminMenu = [
  { key: 'dashboard', label: 'Dashboard', icon: 'home' },
  { key: 'petugas', label: 'Kelola petugas', icon: 'users' },
  { key: 'laporan', label: 'Laporan', icon: 'chart' },
]

export const adminSummary = [
  { label: 'Total member', value: '128' },
  { label: 'Kendaraan hari ini', value: '86' },
  { label: 'Pendapatan hari ini', value: 'Rp 258rb' },
  { label: 'Petugas aktif', value: '3/4' },
]

export const adminWeekly = [
  { day: 'Sen', pct: 55 }, { day: 'Sel', pct: 65 }, { day: 'Rab', pct: 45 },
  { day: 'Kam', pct: 70 }, { day: 'Jum', pct: 85 }, { day: 'Sab', pct: 95 }, { day: 'Min', pct: 60 },
]

export const staffList = [
  { name: 'Rudi Hermawan', email: 'rudi@parkirplaza.id', shift: 'Shift pagi', status: 'Aktif' },
  { name: 'Lina Marlina', email: 'lina@parkirplaza.id', shift: 'Shift siang', status: 'Aktif' },
  { name: 'Agus Setiawan', email: 'agus@parkirplaza.id', shift: 'Shift malam', status: 'Nonaktif' },
  { name: 'Wulan Sari', email: 'wulan@parkirplaza.id', shift: 'Shift pagi', status: 'Aktif' },
]

export const statusStyle = (status: string) => {
  if (status === 'Aktif') return 'bg-emerald-100 text-emerald-700'
  if (status === 'Akan berakhir') return 'bg-amber-100 text-amber-700'
  return 'bg-slate-100 text-slate-500'
}
