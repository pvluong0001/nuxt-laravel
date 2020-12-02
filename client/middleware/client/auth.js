export default function ({ $cookies, redirect }) {
  if (!$cookies.get('clientToken')) {
    redirect('/login');
  }
}
