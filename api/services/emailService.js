const nodemailer = require('nodemailer');

class EmailService {
  constructor() {
    this.transporter = nodemailer.createTransport({
      host: process.env.EMAIL_HOST || 'sandbox.smtp.mailtrap.io',
      port: process.env.EMAIL_PORT || 587,
      secure: process.env.EMAIL_SECURE === 'true' || false,
      auth: {
        user: process.env.EMAIL_USERNAME || 'your-mailtrap-user',
        pass: process.env.EMAIL_PASSWORD || 'your-mailtrap-pass'
      },
      tls: {
        rejectUnauthorized: false
      }
    });
  }

  async sendVerificationEmail(email, name, token) {
    const verificationUrl = `${process.env.FRONTEND_URL || 'http://localhost:8000'}/verify-email?token=${token}`;
    
    const mailOptions = {
      from: `"${process.env.EMAIL_FROM_NAME || 'Promethex'}" <${process.env.EMAIL_FROM || 'noreply@promethex.com'}>`,
      to: email,
      subject: 'Verify Your Email - Promethex',
      html: `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
          <h2 style="color: #333;">Welcome to Promethex!</h2>
          <p>Hi ${name},</p>
          <p>Thank you for registering with Promethex. To complete your registration, please verify your email address by clicking the button below:</p>
          <div style="text-align: center; margin: 30px 0;">
            <a href="${verificationUrl}" 
               style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
              Verify Email Address
            </a>
          </div>
          <p>If the button doesn't work, you can also copy and paste this link into your browser:</p>
          <p style="word-break: break-all; color: #666;">${verificationUrl}</p>
          <p>This verification link will expire in 24 hours.</p>
          <p>If you didn't create an account with Promethex, please ignore this email.</p>
          <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
          <p style="color: #666; font-size: 12px;">
            This email was sent from Promethex E-Commerce Platform.<br>
            If you have any questions, please contact our support team.
          </p>
        </div>
      `
    };

    try {
      const info = await this.transporter.sendMail(mailOptions);
      console.log('Email sent:', info.messageId);
      return true;
    } catch (error) {
      console.error('Error sending email:', error);
      throw new Error('Failed to send verification email');
    }
  }
}

module.exports = new EmailService();
