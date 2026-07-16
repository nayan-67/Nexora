import { useState } from 'react'
import { ChevronLeft, Lock, Smartphone, Eye, EyeOff, LogOut, Shield, AlertCircle, CheckCircle2, Clock, MapPin, Globe } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Card } from '@/components/ui/card'
import { Header } from '@/components/header'
import { Footer } from '@/components/footer'
import { Link } from 'react-router-dom'

export default function SecurityPage() {
  const [showPasswordForm, setShowPasswordForm] = useState(false)
  const [show2FAForm, setShow2FAForm] = useState(false)
  const [showNewPassword, setShowNewPassword] = useState(false)
  const [showConfirmPassword, setShowConfirmPassword] = useState(false)
  const [formData, setFormData] = useState({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
  })
  const [twoFAEnabled, setTwoFAEnabled] = useState(true)
  const [selectedSessions, setSelectedSessions] = useState([])

  const activeSessions = [
    {
      id: 1,
      device: 'Chrome on MacOS',
      ip: '192.168.1.1',
      location: 'San Francisco, CA',
      lastActive: '5 minutes ago',
      current: true,
    },
    {
      id: 2,
      device: 'Safari on iPhone',
      ip: '203.0.113.45',
      location: 'San Francisco, CA',
      lastActive: '2 hours ago',
      current: false,
    },
    {
      id: 3,
      device: 'Firefox on Windows',
      ip: '198.51.100.23',
      location: 'Oakland, CA',
      lastActive: '1 day ago',
      current: false,
    },
  ]

  const loginHistory = [
    {
      id: 1,
      date: 'Today at 2:45 PM',
      device: 'Chrome on MacOS',
      location: 'San Francisco, CA',
      status: 'success',
    },
    {
      id: 2,
      date: 'Today at 9:15 AM',
      device: 'Safari on iPhone',
      location: 'San Francisco, CA',
      status: 'success',
    },
    {
      id: 3,
      date: 'Yesterday at 11:30 PM',
      device: 'Firefox on Windows',
      location: 'Oakland, CA',
      status: 'success',
    },
    {
      id: 4,
      date: '3 days ago at 8:20 PM',
      device: 'Unknown Device',
      location: 'New York, NY',
      status: 'failed',
    },
  ]

  const handlePasswordChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    })
  }

  const handlePasswordSubmit = (e) => {
    e.preventDefault()
    if (formData.newPassword !== formData.confirmPassword) {
      alert('Passwords do not match')
      return
    }
    alert('Password updated successfully')
    setFormData({ currentPassword: '', newPassword: '', confirmPassword: '' })
    setShowPasswordForm(false)
  }

  const handleToggleSession = (sessionId) => {
    setSelectedSessions((prev) =>
      prev.includes(sessionId)
        ? prev.filter((id) => id !== sessionId)
        : [...prev, sessionId]
    )
  }

  const handleLogoutSessions = () => {
    if (selectedSessions.length === 0) {
      alert('Please select at least one session')
      return
    }
    alert(`Logged out ${selectedSessions.length} session(s)`)
    setSelectedSessions([])
  }

  return (
    <div className="flex min-h-screen flex-col bg-background">
      <Header />
      <main className="flex-1">
        {/* Breadcrumb */}
        <div className="border-b border-border/40">
          <div className="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <Link
              to="/profile"
              className="inline-flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
            >
              <ChevronLeft className="h-4 w-4" />
              Back to Profile
            </Link>
          </div>
        </div>

        <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
          {/* Header */}
          <div className="mb-8">
            <div className="flex items-center gap-3">
              <div className="rounded-lg bg-primary/10 p-3">
                <Shield className="h-6 w-6 text-primary" />
              </div>
              <div>
                <h1
                  className="text-3xl font-bold text-foreground sm:text-4xl"
                  style={{ fontFamily: 'var(--font-heading)' }}
                >
                  Security Settings
                </h1>
                <p className="mt-1 text-muted-foreground">
                  Manage your account security and privacy
                </p>
              </div>
            </div>
          </div>

          <div className="grid gap-8 lg:grid-cols-3">
            {/* Main Content */}
            <div className="space-y-6 lg:col-span-2">
              {/* Password Section */}
              <Card className="overflow-hidden border border-border/50 bg-card p-6">
                <div className="flex items-start justify-between">
                  <div className="flex gap-4">
                    <div className="rounded-lg bg-blue-100 p-3">
                      <Lock className="h-5 w-5 text-blue-600" />
                    </div>
                    <div>
                      <h3 className="font-semibold text-foreground">Password</h3>
                      <p className="mt-1 text-sm text-muted-foreground">
                        Last changed 3 months ago
                      </p>
                    </div>
                  </div>
                  <Button
                    variant="outline"
                    onClick={() => setShowPasswordForm(!showPasswordForm)}
                  >
                    {showPasswordForm ? 'Cancel' : 'Change Password'}
                  </Button>
                </div>

                {showPasswordForm && (
                  <form onSubmit={handlePasswordSubmit} className="mt-6 space-y-4 border-t border-border/40 pt-6">
                    <div>
                      <label className="block text-sm font-medium text-foreground">
                        Current Password
                      </label>
                      <input
                        type="password"
                        name="currentPassword"
                        value={formData.currentPassword}
                        onChange={handlePasswordChange}
                        placeholder="Enter your current password"
                        className="mt-2 w-full rounded-lg border border-border/50 bg-background px-4 py-2 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        required
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-foreground">
                        New Password
                      </label>
                      <div className="relative mt-2">
                        <input
                          type={showNewPassword ? 'text' : 'password'}
                          name="newPassword"
                          value={formData.newPassword}
                          onChange={handlePasswordChange}
                          placeholder="Enter new password"
                          className="w-full rounded-lg border border-border/50 bg-background px-4 py-2 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                          required
                        />
                        <button
                          type="button"
                          onClick={() => setShowNewPassword(!showNewPassword)}
                          className="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground"
                        >
                          {showNewPassword ? (
                            <EyeOff className="h-4 w-4" />
                          ) : (
                            <Eye className="h-4 w-4" />
                          )}
                        </button>
                      </div>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-foreground">
                        Confirm Password
                      </label>
                      <div className="relative mt-2">
                        <input
                          type={showConfirmPassword ? 'text' : 'password'}
                          name="confirmPassword"
                          value={formData.confirmPassword}
                          onChange={handlePasswordChange}
                          placeholder="Confirm new password"
                          className="w-full rounded-lg border border-border/50 bg-background px-4 py-2 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                          required
                        />
                        <button
                          type="button"
                          onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                          className="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground"
                        >
                          {showConfirmPassword ? (
                            <EyeOff className="h-4 w-4" />
                          ) : (
                            <Eye className="h-4 w-4" />
                          )}
                        </button>
                      </div>
                    </div>
                    <div className="flex gap-3 pt-2">
                      <Button type="submit" className="flex-1">
                        Update Password
                      </Button>
                      <Button
                        type="button"
                        variant="outline"
                        className="flex-1"
                        onClick={() => setShowPasswordForm(false)}
                      >
                        Cancel
                      </Button>
                    </div>
                  </form>
                )}
              </Card>

              {/* Two-Factor Authentication */}
              <Card className="overflow-hidden border border-border/50 bg-card p-6">
                <div className="flex items-start justify-between">
                  <div className="flex gap-4">
                    <div className="rounded-lg bg-green-100 p-3">
                      <Smartphone className="h-5 w-5 text-green-600" />
                    </div>
                    <div>
                      <h3 className="font-semibold text-foreground">
                        Two-Factor Authentication
                      </h3>
                      <p className="mt-1 text-sm text-muted-foreground">
                        {twoFAEnabled ? (
                          <span className="flex items-center gap-1 text-green-600">
                            <CheckCircle2 className="h-4 w-4" />
                            Enabled via authenticator app
                          </span>
                        ) : (
                          'Not enabled'
                        )}
                      </p>
                    </div>
                  </div>
                  <Button
                    variant="outline"
                    onClick={() => setShow2FAForm(!show2FAForm)}
                  >
                    {show2FAForm ? 'Cancel' : twoFAEnabled ? 'Manage' : 'Enable'}
                  </Button>
                </div>

                {show2FAForm && (
                  <div className="mt-6 space-y-4 border-t border-border/40 pt-6">
                    <div className="rounded-lg bg-accent/50 p-4">
                      <p className="text-sm text-foreground">
                        Two-factor authentication adds an extra layer of security to your account.
                      </p>
                    </div>
                    {twoFAEnabled && (
                      <div className="space-y-3">
                        <p className="text-sm font-medium text-foreground">
                          Backup codes:
                        </p>
                        <div className="grid grid-cols-2 gap-2">
                          {['ABCD-1234', 'EFGH-5678', 'IJKL-9012'].map((code, idx) => (
                            <div
                              key={idx}
                              className="rounded border border-border/50 bg-background px-3 py-2 font-mono text-xs text-foreground"
                            >
                              {code}
                            </div>
                          ))}
                        </div>
                      </div>
                    )}
                    <Button
                      className="w-full"
                      onClick={() => alert(twoFAEnabled ? 'Disabled 2FA' : 'Enabled 2FA')}
                    >
                      {twoFAEnabled ? 'Disable 2FA' : 'Enable 2FA'}
                    </Button>
                  </div>
                )}
              </Card>

              {/* Active Sessions */}
              <Card className="overflow-hidden border border-border/50 bg-card">
                <div className="border-b border-border/40 p-6">
                  <h3 className="font-semibold text-foreground">Active Sessions</h3>
                  <p className="mt-1 text-sm text-muted-foreground">
                    Manage devices logged into your account
                  </p>
                </div>

                <div className="divide-y divide-border/40">
                  {activeSessions.map((session) => (
                    <div key={session.id} className="flex items-start gap-4 p-6">
                      <input
                        type="checkbox"
                        checked={selectedSessions.includes(session.id)}
                        onChange={() => handleToggleSession(session.id)}
                        disabled={session.current}
                        className="mt-1 h-4 w-4 cursor-pointer rounded border-border/50"
                      />
                      <div className="flex-1">
                        <div className="flex items-center gap-2">
                          <p className="font-medium text-foreground">
                            {session.device}
                          </p>
                          {session.current && (
                            <span className="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                              <CheckCircle2 className="h-3 w-3" />
                              Current
                            </span>
                          )}
                        </div>
                        <div className="mt-2 space-y-1 text-sm text-muted-foreground">
                          <div className="flex items-center gap-2">
                            <Globe className="h-4 w-4" />
                            {session.ip}
                          </div>
                          <div className="flex items-center gap-2">
                            <MapPin className="h-4 w-4" />
                            {session.location}
                          </div>
                          <div className="flex items-center gap-2">
                            <Clock className="h-4 w-4" />
                            Last active: {session.lastActive}
                          </div>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>

                {selectedSessions.length > 0 && (
                  <div className="border-t border-border/40 p-6">
                    <Button
                      variant="destructive"
                      className="w-full"
                      onClick={handleLogoutSessions}
                    >
                      <LogOut className="mr-2 h-4 w-4" />
                      Logout {selectedSessions.length} Selected Session
                      {selectedSessions.length > 1 ? 's' : ''}
                    </Button>
                  </div>
                )}
              </Card>

              {/* Login History */}
              <Card className="overflow-hidden border border-border/50 bg-card">
                <div className="border-b border-border/40 p-6">
                  <h3 className="font-semibold text-foreground">Login History</h3>
                  <p className="mt-1 text-sm text-muted-foreground">
                    Recent login attempts to your account
                  </p>
                </div>

                <div className="divide-y divide-border/40">
                  {loginHistory.map((login) => (
                    <div key={login.id} className="flex items-start gap-4 p-6">
                      <div>
                        {login.status === 'success' ? (
                          <CheckCircle2 className="h-5 w-5 text-green-600" />
                        ) : (
                          <AlertCircle className="h-5 w-5 text-red-600" />
                        )}
                      </div>
                      <div className="flex-1">
                        <p className="font-medium text-foreground">{login.date}</p>
                        <div className="mt-1 space-y-1 text-sm text-muted-foreground">
                          <p>{login.device}</p>
                          <p className="flex items-center gap-2">
                            <MapPin className="h-3 w-3" />
                            {login.location}
                          </p>
                        </div>
                      </div>
                      <div className="text-right">
                        <span
                          className={`inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium ${
                            login.status === 'success'
                              ? 'bg-green-100 text-green-700'
                              : 'bg-red-100 text-red-700'
                          }`}
                        >
                          {login.status === 'success' ? 'Success' : 'Failed'}
                        </span>
                      </div>
                    </div>
                  ))}
                </div>
              </Card>
            </div>

            {/* Sidebar */}
            <div className="space-y-6">
              {/* Security Tips */}
              <Card className="overflow-hidden border border-border/50 bg-card p-6">
                <h4 className="font-semibold text-foreground">Security Tips</h4>
                <ul className="mt-4 space-y-3 text-sm text-muted-foreground">
                  <li className="flex gap-2">
                    <span className="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                    Use a strong, unique password
                  </li>
                  <li className="flex gap-2">
                    <span className="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                    Enable two-factor authentication
                  </li>
                  <li className="flex gap-2">
                    <span className="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                    Review active sessions regularly
                  </li>
                  <li className="flex gap-2">
                    <span className="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                    Never share your password
                  </li>
                  <li className="flex gap-2">
                    <span className="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                    Logout from unused sessions
                  </li>
                </ul>
              </Card>

              {/* Security Status */}
              <Card className="overflow-hidden border border-border/50 bg-card p-6">
                <h4 className="font-semibold text-foreground">Security Status</h4>
                <div className="mt-4 space-y-3">
                  <div className="flex items-center gap-2">
                    <CheckCircle2 className="h-5 w-5 text-green-600" />
                    <span className="text-sm text-muted-foreground">
                      Strong password set
                    </span>
                  </div>
                  <div className="flex items-center gap-2">
                    <CheckCircle2 className="h-5 w-5 text-green-600" />
                    <span className="text-sm text-muted-foreground">
                      2FA enabled
                    </span>
                  </div>
                  <div className="flex items-center gap-2">
                    <CheckCircle2 className="h-5 w-5 text-green-600" />
                    <span className="text-sm text-muted-foreground">
                      Email verified
                    </span>
                  </div>
                </div>
              </Card>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </div>
  )
}
