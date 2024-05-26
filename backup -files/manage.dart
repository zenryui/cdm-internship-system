Imports MySql.Data.MySqlClient
Imports System.IO

Public Class form_ManageStudent

    'ADDED NEW START HERE'

    Private WithEvents FadeInTimer As New Timer()
    Private WithEvents FadeOutTimer As New Timer()

    ' Specify the full paths to your images
    Private hoverImagePath As String = "C:\Users\Ferg\Desktop\ICS  Student Voting System\remove.png"
    Private originalImagePath As String = "C:\Users\Ferg\Desktop\ICS ICONS\remove.png"

    Private Sub form_ManageStudent_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        DatabaseConnection.dbconn()
        Auto_studentID()
        Load_studentData()

        ' Add buttons to the DataGridView
        Dim btnApprove As New DataGridViewButtonColumn()
        btnApprove.HeaderText = "Approve"
        btnApprove.Name = "btnApprove"
        btnApprove.Text = "Approve"
        btnApprove.UseColumnTextForButtonValue = True

        Dim btnDecline As New DataGridViewButtonColumn()
        btnDecline.HeaderText = "Decline"
        btnDecline.Name = "btnDecline"
        btnDecline.Text = "Decline"
        btnDecline.UseColumnTextForButtonValue = True

        Guna2DataGridView1.Columns.Add(btnApprove)
        Guna2DataGridView1.Columns.Add(btnDecline)
    End Sub


    Private Sub FadeInTimer_Tick(sender As Object, e As EventArgs) Handles FadeInTimer.Tick
        ' Increase the opacity gradually (faster)
        If Me.Opacity < 1 Then
            Me.Opacity += 0.3 ' You can adjust the step size as needed
        Else
            ' Stop the timer once opacity reaches 1
            FadeInTimer.Stop()
        End If
    End Sub

    Private Sub pic_close_Click(sender As Object, e As EventArgs) Handles pic_close.Click
        ' Start the timer to fade out the form when closing
        FadeOutTimer.Start()
    End Sub

    Private Sub FadeOutTimer_Tick(sender As Object, e As EventArgs) Handles FadeOutTimer.Tick
        ' Decrease the opacity gradually (faster)
        If Me.Opacity > 0 Then
            Me.Opacity -= 0.3 ' You can adjust the step size as needed
        Else
            ' Close the form once opacity reaches 0
            Me.Close()
        End If
    End Sub

    'END HERE'

    Sub Load_studentData()
        Guna2DataGridView1.Rows.Clear()

        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=cdm-internship-database")
                conn.Open()

                Using cmd As New MySqlCommand("SELECT `internship_ID`, `Title`, `Description`, `Requirements`, `Duration`, `Status` FROM `internship`", conn)
                    Using dr As MySqlDataReader = cmd.ExecuteReader()
                        While dr.Read
                            Guna2DataGridView1.Rows.Add(Guna2DataGridView1.Rows.Count + 1, dr.Item("internship_ID"), dr.Item("Title"), dr.Item("Description"), dr.Item("Requirements"), dr.Item("Duration"), dr.Item("Status"), "Approve", "Decline")
                        End While
                    End Using
                End Using
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub

    Private Sub txt_search_TextChanged(sender As Object, e As EventArgs) Handles txt_search.TextChanged
        Guna2DataGridView1.Rows.Clear()

        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=election_database")
                conn.Open()

                Using cmd As New MySqlCommand("SELECT * FROM `table_student` WHERE student_id LIKE '%" & txt_search.Text & "%' OR Name LIKE '%" & txt_search.Text & "%' OR course LIKE '%" & txt_search.Text & "%' OR status LIKE '%" & txt_search.Text & "%'", conn)
                    Using dr As MySqlDataReader = cmd.ExecuteReader()
                        While dr.Read
                            Guna2DataGridView1.Rows.Add(Guna2DataGridView1.Rows.Count + 1, dr.Item("student_id"), dr.Item("name"), dr.Item("course"), dr.Item("year"), dr.Item("status"))
                        End While
                    End Using
                End Using
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub

    Sub clear()
        txt_studentName.Clear()
        cmb_course.SelectedIndex = -1
        cmb_year.SelectedIndex = -1
    End Sub

    Sub Auto_studentID()
        Dim dr As MySqlDataReader

        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=election_database")
                conn.Open()

                cmd = New MySqlCommand("SELECT * FROM `table_student` ORDER BY id DESC", conn)
                dr = cmd.ExecuteReader()
                dr.Read()

                If dr.HasRows Then
                    txt_studentID.Text = (Convert.ToInt32(dr.Item("student_id")) + 1).ToString()
                Else
                    txt_studentID.Text = Date.Now.ToString("yyyy") & "001"
                End If
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub

    Private Sub btn_register_Click(sender As Object, e As EventArgs) Handles btn_register.Click
        Dim i As Integer
        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=election_database")
                conn.Open()
                cmd = New MySqlCommand("INSERT INTO `activated_employer`(`email`, `password`)", conn)
                cmd.Parameters.Clear()
                cmd.Parameters.AddWithValue("@student_id", txt_studentID.Text)
                cmd.Parameters.AddWithValue("@name", txt_studentName.Text)
                cmd.Parameters.AddWithValue("@course", cmb_course.Text)
                cmd.Parameters.AddWithValue("@year", cmb_year.Text)
                cmd.Parameters.AddWithValue("@status", "UN-VOTED")
                i = cmd.ExecuteNonQuery()
                If i > 0 Then
                    MsgBox("Student Register Success!", vbInformation, "VOTE")
                Else
                    MsgBox("Student Register Failed!", vbCritical, "VOTE")
                End If
            End Using
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try

        clear()
        Auto_studentID()
        Load_studentData()
    End Sub

    Private Sub Guna2DataGridView1_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles Guna2DataGridView1.CellContentClick
        If e.ColumnIndex = Guna2DataGridView1.Columns("btnApprove").Index Then
            ' Approve button clicked
            Dim selectedRow As DataGridViewRow = Guna2DataGridView1.Rows(e.RowIndex)
            Dim internshipID As Integer = Convert.ToInt32(selectedRow.Cells("internship_ID").Value)
            UpdateInternshipStatus(internshipID, "Posted")
        ElseIf e.ColumnIndex = Guna2DataGridView1.Columns("btnDecline").Index Then
            ' Decline button clicked
            Dim selectedRow As DataGridViewRow = Guna2DataGridView1.Rows(e.RowIndex)
            Dim internshipID As Integer = Convert.ToInt32(selectedRow.Cells("internship_ID").Value)
            UpdateInternshipStatus(internshipID, "Declined")
        End If
    End Sub

    Private Sub UpdateInternshipStatus(internshipID As Integer, newStatus As String)
        Try
            Using conn As New MySqlConnection("server=localhost;user=root;password=2474;database=cdm-internship-database")
                conn.Open()

                Using cmd As New MySqlCommand("UPDATE `internship` SET `Status` = @Status WHERE `internship_ID` = @internship_ID", conn)
                    cmd.Parameters.AddWithValue("@Status", newStatus)
                    cmd.Parameters.AddWithValue("@internship_ID", internshipID)
                    cmd.ExecuteNonQuery()
                End Using
            End Using
            MessageBox.Show("Status updated to: " & newStatus)
            Load_studentData() ' Refresh the data grid view
        Catch ex As Exception
            MsgBox(ex.Message)
        End Try
    End Sub







End Class
