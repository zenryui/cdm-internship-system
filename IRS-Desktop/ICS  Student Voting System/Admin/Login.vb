Imports MySql.Data.MySqlClient
Imports System.IO

Public Class Login
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load

    End Sub

    Private Sub btn_login_Click(sender As Object, e As EventArgs) Handles btn_login.Click
        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=cdm-internship-database")
                conn.Open()

                ' Check if the username exists
                Dim storedPassword As String = String.Empty
                Using cmd As New MySqlCommand("SELECT `admin_password` FROM `admin` WHERE `admin_username` = @Username", conn)
                    cmd.Parameters.AddWithValue("@Username", admin_username.Text)
                    Using dr As MySqlDataReader = cmd.ExecuteReader()
                        If dr.Read() Then
                            storedPassword = dr("admin_password").ToString()
                        End If
                    End Using
                End Using

                ' If the username does not exist
                If String.IsNullOrEmpty(storedPassword) Then
                    MsgBox("Wrong username", vbCritical, "Login Failed")
                    admi_password.Clear()
                    Return
                End If

                ' Verify the password
                If BCrypt.Net.BCrypt.Verify(admi_password.Text, storedPassword) Then
                    MsgBox("Login success!", vbInformation, "Login")
                    Me.Hide()
                    Dim manageStudentForm As New Dashboard()
                    manageStudentForm.ShowDialog()
                    Me.Close()
                Else
                    MsgBox("Wrong password", vbCritical, "Login Failed")
                    admi_password.Clear()
                End If

            End Using
        Catch ex As Exception
            MsgBox("An error occurred: " & ex.Message, vbCritical, "Login Failed")
        End Try
    End Sub

    Private Sub btn_exit_Click(sender As Object, e As EventArgs) Handles btn_exit.Click
        Dim result As DialogResult = MessageBox.Show("Are you sure you want to close the application?", "Confirm Exit", MessageBoxButtons.YesNo, MessageBoxIcon.Question)
        If result = DialogResult.Yes Then
            Me.Close()
        End If

    End Sub
End Class
